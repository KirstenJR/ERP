<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $esAdmin ? 'Panel de administración' : 'Mi panel' }}
        </h2>
    </x-slot>
 
    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
 
            <p class="text-gray-700">Hola, <span class="font-semibold">{{ auth()->user()->name }}</span>.</p>
 
            {{-- Tarjetas --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div class="bg-white p-5 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">{{ $esAdmin ? 'Coches registrados' : 'Mis coches' }}</p>
                    <p class="text-3xl font-semibold text-gray-900">{{ $totalCoches }}</p>
                </div>
                <div class="bg-white p-5 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Iniciados este mes</p>
                    <p class="text-3xl font-semibold text-gray-900">{{ $cochesDelMes }}</p>
                </div>
                @if ($esAdmin)
                    <div class="bg-white p-5 shadow-sm sm:rounded-lg">
                        <p class="text-sm text-gray-500">Usuarios</p>
                        <p class="text-3xl font-semibold text-gray-900">{{ $totalUsuarios }}</p>
                    </div>
                @endif
            </div>
 
            {{-- Barras por operador (solo admin) --}}
            @if ($esAdmin)
                @php($maximo = max(1, $porOperador->max('cars_count')))
                <div class="bg-white p-5 shadow-sm sm:rounded-lg">
                    <h3 class="mb-3 text-sm font-semibold text-gray-700">Coches por operador</h3>
                    @foreach ($porOperador as $fila)
                        <div class="mb-2">
                            <div class="flex justify-between text-sm text-gray-700">
                                <span>{{ $fila->name }}</span>
                                <span>{{ $fila->cars_count }}</span>
                            </div>
                            <div class="h-2 rounded bg-gray-100">
                                <div class="h-2 rounded bg-indigo-500" style="width: {{ round($fila->cars_count / $maximo * 100) }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
 
            {{-- Últimos registros --}}
            <div class="overflow-x-auto bg-white shadow-sm sm:rounded-lg">
                <h3 class="px-4 pt-4 text-sm font-semibold text-gray-700">Últimos 5 registros</h3>
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="text-left text-xs font-medium uppercase text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Matrícula</th>
                            <th class="px-4 py-3">Operador</th>
                            <th class="px-4 py-3">Fecha de inicio</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($ultimos as $car)
                            <tr>
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $car->matricula }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $car->user->name }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $car->fecha_inicio->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-4 py-6 text-center text-gray-500">Sin registros todavía.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
