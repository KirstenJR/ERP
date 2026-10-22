# Sistema de Gestión y Control Vehicular

Aplicación web desarrollada con **Laravel y MySQL** para administrar vehículos, usuarios y operaciones relacionadas con una flota vehicular.

El proyecto busca centralizar la información, facilitar los procesos administrativos y ofrecer herramientas de consulta y generación de reportes mediante una interfaz web.

**Estado:** En desarrollo y estabilización.

## Tecnologías utilizadas

- **Backend:** PHP, Laravel
- **Base de datos:** MySQL
- **Frontend:** Blade, Tailwind CSS, JavaScript
- **ORM:** Eloquent
- **Control de versiones:** Git y GitHub
- **Gestión de dependencias:** Composer y npm

## Funcionalidades

### Autenticación y usuarios

- Inicio y cierre de sesión.
- Administración de usuarios.
- Roles de administrador y operador.
- Control de acceso a funcionalidades según el rol.

### Gestión de vehículos

- Registro de vehículos.
- Consulta y edición de información.
- Eliminación de registros según permisos.
- Asociación de vehículos con usuarios.
- Filtros y búsqueda de registros.

### Panel administrativo

- Dashboard con información general del sistema.
- Indicadores de vehículos y operaciones.
- Acceso a los módulos administrativos.

### Reportes

- Generación de reportes PDF.
- Exportación de información a Excel.

> Las funcionalidades descritas corresponden al alcance conocido del proyecto. Su funcionamiento y permisos deben verificarse durante la estabilización.

## Funcionalidades planificadas

Las siguientes mejoras forman parte de la evolución del proyecto:

- Historial de asignaciones de vehículos.
- Reasignación con cierre automático de la asignación anterior.
- Restricción de una sola asignación activa por vehículo.
- Pruebas automatizadas de operaciones y permisos.
- Validación de integridad de datos y concurrencia.
- Integración continua con GitHub Actions.
- Mejoras de usabilidad, rendimiento y documentación.

## Instalación local

### Requisitos

- PHP y extensiones compatibles con la versión de Laravel utilizada.
- Composer.
- MySQL.
- Node.js y npm.
- Git.

### 1. Clonar el repositorio

```bash
git clone <URL_DEL_REPOSITORIO>
cd <NOMBRE_DEL_PROYECTO>
```

### 2. Instalar dependencias

```bash
composer install
npm install
```

### 3. Configurar el entorno

```bash
cp .env.example .env
php artisan key:generate
```

Editar `.env` con las credenciales de una base de datos local:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestion_vehicular
DB_USERNAME=usuario_local
DB_PASSWORD=contraseña_local
```

### 4. Preparar la base de datos

Crear previamente la base de datos configurada y ejecutar:

```bash
php artisan migrate
```

Para cargar datos de demostración, únicamente si el proyecto cuenta con seeders preparados:

```bash
php artisan db:seed
```

### 5. Iniciar la aplicación

En una terminal:

```bash
php artisan serve
```

En otra terminal:

```bash
npm run dev
```

Abrir la dirección indicada por Laravel, normalmente:

`http://127.0.0.1:8000`

**Nota:** estos pasos son una guía inicial. Deben validarse en una instalación limpia antes de considerar reproducible el proyecto.

## Pruebas

Ejecutar las pruebas disponibles mediante:

```bash
php artisan test
```

El proyecto se encuentra en proceso de ampliar su cobertura de pruebas, especialmente en gestión de vehículos, usuarios, autorización y reglas de asignación.

## Estructura del proyecto

```text
app/
├── Http/
│   ├── Controllers/
│   └── Requests/
├── Models/
└── Policies/

database/
├── migrations/
└── seeders/

resources/
└── views/

routes/
└── web.php

tests/
├── Feature/
└── Unit/
```

## Próximas etapas

| Etapa | Objetivo |
|---|---|
| 1 | Estabilización y corrección de errores |
| 2 | Revisión de autenticación y permisos |
| 3 | Pruebas de gestión de vehículos y usuarios |
| 4 | Implementación del historial de asignaciones |
| 5 | Validación de reglas de negocio |
| 6 | Mejoras de dashboard y reportes |
| 7 | Automatización de pruebas y revisión de seguridad |
| 8 | Documentación y publicación de la versión 1.0 |

## Autor

**Kirsten Jafet Robles Cervantes**  
Ingeniero en Sistemas Computacionales  
Desarrollador Backend Junior — PHP / Laravel / MySQL

## Nota sobre el proyecto

Proyecto independiente de portafolio, desarrollado con fines de aprendizaje y demostración de competencias técnicas.

No contiene código propietario ni información confidencial de empleadores anteriores.