<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Reporte de coches</h2>
    </x-slot>
 
    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
 
            {{-- Filtros --}}
            <form method="GET" action="{{ route('reports.index') }}" class="bg-white p-4 shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                    <div>
                        <x-input-label for="user_id" value="Operador" />
                        <select id="user_id" name="user_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Todos</option>
                            @foreach ($users as $u)
                                <option value="{{ $u->id }}" @selected((string) request('user_id') === (string) $u->id)>{{ $u->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                    </div>
 
                    <div>
                        <x-input-label for="desde" value="Desde" />
                        <x-text-input id="desde" name="desde" type="date" class="mt-1 block w-full" :value="request('desde')" />
                        <x-input-error :messages="$errors->get('desde')" class="mt-2" />
                    </div>
 
                    <div>
                        <x-input-label for="hasta" value="Hasta" />
                        <x-text-input id="hasta" name="hasta" type="date" class="mt-1 block w-full" :value="request('hasta')" />
                        <x-input-error :messages="$errors->get('hasta')" class="mt-2" />
                    </div>
 
                    <div class="flex items-end gap-3">
                        <x-primary-button>Filtrar</x-primary-button>
                        <a href="{{ route('reports.index') }}" class="text-sm text-gray-600 hover:underline">Limpiar</a>
                    </div>
                </div>
            </form>
 
            {{-- Totales --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div class="bg-white p-4 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Total de coches</p>
                    <p class="text-3xl font-semibold text-gray-900">{{ $total }}</p>
                </div>
                <div class="bg-white p-4 shadow-sm sm:rounded-lg md:col-span-2">
                    <p class="mb-2 text-sm text-gray-500">Por operador</p>
                    @forelse ($porOperador as $fila)
                        <div class="flex justify-between border-b border-gray-100 py-1 text-sm">
                            <span>{{ $fila->user->name }}</span>
                            <span class="font-medium">{{ $fila->total }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Sin resultados.</p>
                    @endforelse
                </div>
            </div>
 
            {{-- Detalle --}}
            <div class="overflow-x-auto bg-white shadow-sm sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-left text-xs font-medium uppercase text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Matrícula</th>
                            <th class="px-4 py-3">Operador</th>
                            <th class="px-4 py-3">Fecha de inicio</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($cars as $car)
                            <tr>
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $car->matricula }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $car->user->name }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $car->fecha_inicio->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-gray-500">No hay coches con esos filtros.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
 
            <div>{{ $cars->links() }}</div>
        </div>
    </div>
</x-app-layout>
