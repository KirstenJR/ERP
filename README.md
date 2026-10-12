# ERP de inventario de coches

Aplicación web interna, hecha con **Laravel**, para registrar y consultar el inventario de coches de una operación: qué operador tiene cada coche, con qué matrícula y desde qué fecha. Incluye inicio de sesión con dos roles (administrador y operador), gestión de usuarios, reportes con filtros exportables a PDF y Excel, un panel de indicadores y pruebas automáticas de permisos.

> Proyecto de portafolio. Los usuarios de demostración que aparecen abajo son solo para desarrollo.


## Qué puede hacer

| Acción | Operador | Administrador |
|---|---|---|
| Iniciar sesión y editar su perfil | Sí | Sí |
| Ver coches | Solo los suyos | Todos |
| Registrar coches | A su nombre | A nombre de cualquier usuario |
| Editar y eliminar coches | Solo los suyos | Todos |
| Gestionar usuarios | No | Sí |
| Reporte con filtros, PDF y Excel | No | Sí |
| Dashboard | Solo sus cifras | Cifras globales y barras por operador |

El registro público está desactivado: los usuarios los crea el administrador.

## Tecnologías

- PHP 8.3 o superior y Laravel 13
- MySQL
- Laravel Breeze (Blade, Alpine.js, Tailwind CSS) y Vite
- `barryvdh/laravel-dompdf` para PDF y `maatwebsite/excel` para Excel
- Pruebas con el ejecutor de Laravel (`php artisan test`)

## Decisiones de seguridad

- **Los permisos se aplican en el servidor.** Ocultar un botón en la vista no protege nada; cada acción se valida con middleware de rol, Policies y `Gate::authorize`.
- **No se confía en lo que envía el cliente.** Un operador no puede registrar ni reasignar coches a otro usuario aunque edite el formulario; el rol se valida con `in:admin,operador`.
- **Defensa en capas.** La matrícula es única tanto en la validación como en la base de datos, y las llaves foráneas impiden dejar coches huérfanos.
- **Reglas de negocio:** un administrador no puede quitarse su rol ni eliminarse, y no se puede eliminar a un usuario que tenga coches.
- **Puertas de Breeze cerradas:** se eliminó el registro público, la página de bienvenida y el borrado de cuenta desde el perfil, que habría saltado las reglas anteriores.
- Las contraseñas se guardan con hash y las vistas escapan la salida de forma automática.

## Instalación

Requisitos: PHP 8.3+ (con las extensiones `mbstring`, `xml`, `curl`, `zip`, `mysql`, `gd`), Composer, MySQL y Node.js.

```bash
git clone <URL-DEL-REPOSITORIO> erp-coches
cd erp-coches

composer install
npm install

cp .env.example .env
php artisan key:generate
```

Crea la base de datos en MySQL y configura en `.env` los valores `DB_DATABASE`, `DB_USERNAME` y `DB_PASSWORD`:

```sql
CREATE DATABASE erp_coches CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Migra y carga los usuarios de demostración:

```bash
php artisan migrate --seed
```

Inicia la aplicación en dos terminales:

```bash
php artisan serve
npm run dev
```

Abre <http://127.0.0.1:8000>.

### Usuarios de demostración

| Rol | Correo | Contraseña |
|---|---|---|
| Administrador | `admin@gmail.com` | `admin123` |
| Operador | `operator@gmail.com` | `operator123` |

Solo para desarrollo. En un servidor real crea el primer administrador con una contraseña fuerte y no ejecutes el seeder.

### Datos de ejemplo (opcional)

```bash
php artisan db:seed --class=DemoSeeder
```

Crea tres operadores adicionales (contraseña `password`) y 20 coches.

## Pruebas

Las pruebas usan una base de datos aparte, porque vacían las tablas en cada ejecución.

```sql
CREATE DATABASE erp_coches_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
GRANT ALL PRIVILEGES ON erp_coches_test.* TO 'TU_USUARIO'@'localhost';
```

`phpunit.xml` ya apunta a `erp_coches_test`. Para ejecutarlas:

```bash
php artisan test
```

Cubren, entre otras cosas, que un operador no pueda ver, editar ni eliminar coches ajenos, que no pueda acceder a usuarios ni reportes, las reglas de gestión de usuarios, los filtros del reporte y las descargas de PDF y Excel.

## Estructura relevante

```
app/
  Exports/CarsReportExport.php        Exportación a Excel
  Http/Controllers/                   Car, User, Report y Dashboard
  Http/Middleware/RoleMiddleware.php  Middleware de rol (alias "role")
  Http/Requests/                      Validaciones de coches y usuarios
  Models/                             Car y User
  Policies/CarPolicy.php              Quién puede editar o eliminar un coche
resources/views/                      cars, users, reports, dashboard
routes/web.php
tests/Feature/                        Pruebas de permisos, usuarios y reportes
```

## Rutas principales

| Ruta | Acceso |
|---|---|
| `/dashboard` | Cualquier usuario con sesión |
| `/cars` (listado, alta, edición, baja) | Cualquier usuario con sesión; edición y baja según la Policy |
| `/users` | Solo administrador |
| `/reports`, `/reports/pdf`, `/reports/excel` | Solo administrador |

## Despliegue

En un servidor, el servidor web debe apuntar a la carpeta `public`, y el `.env` debe tener `APP_ENV=production` y `APP_DEBUG=false`. Pasos habituales:

```bash
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan migrate --force
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

## Autor

**Kirsten J. Robles** 
