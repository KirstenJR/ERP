<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte de coches</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #222; }
        h1 { font-size: 18px; margin-bottom: 4px; }
        .meta { color: #555; margin-bottom: 14px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #1f3a5f; color: #fff; text-align: left; padding: 6px; }
        td { padding: 6px; border-bottom: 1px solid #ddd; }
        .total { margin-top: 12px; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Reporte de coches</h1>
    <div class="meta">
        Generado: {{ now()->format('d/m/Y H:i') }}<br>
        Operador: {{ $operador ?? 'Todos' }}<br>
        Desde: {{ !empty($filtros['desde']) ? \Illuminate\Support\Carbon::parse($filtros['desde'])->format('d/m/Y') : '—' }}
        &nbsp; Hasta: {{ !empty($filtros['hasta']) ? \Illuminate\Support\Carbon::parse($filtros['hasta'])->format('d/m/Y') : '—' }}
    </div>
 
    <table>
        <thead>
            <tr>
                <th>Matrícula</th>
                <th>Operador</th>
                <th>Fecha de inicio</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cars as $car)
                <tr>
                    <td>{{ $car->matricula }}</td>
                    <td>{{ $car->user->name }}</td>
                    <td>{{ $car->fecha_inicio->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="3">No hay coches con esos filtros.</td></tr>
            @endforelse
        </tbody>
    </table>
 
    <p class="total">Total: {{ $total }}</p>
</body>
</html>