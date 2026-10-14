<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Coches</h2>
            <a href="{{ route('cars.create') }}"
               class="rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-gray-700">
                Registrar coche
            </a>
        </div>
    </x-slot>
 
    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-flash />
 
            <div class="overflow-x-auto bg-white shadow-sm sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-left text-xs font-medium uppercase text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Matrícula</th>
                            <th class="px-4 py-3">Operador</th>
                            <th class="px-4 py-3">Fecha de inicio</th>
                            <th class="px-4 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($cars as $car)
                            <tr>
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $car->matricula }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $car->user->name }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ \Illuminate\Support\Carbon::parse($car->fecha_inicio)->format('d/m/Y') }}</td>
                                <td class="px-4 py-3 text-right">
                                    @can('update', $car)
                                        <a href="{{ route('cars.edit', $car) }}" class="text-indigo-600 hover:underline">Editar</a>
                                    @endcan
                                    @can('delete', $car)
                                        <form method="POST" action="{{ route('cars.destroy', $car) }}" class="ml-3 inline"
                                              onsubmit="return confirm('¿Eliminar el coche {{ $car->matricula }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-500">Todavía no hay coches registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
 
            <div class="mt-4">{{ $cars->links() }}</div>
        </div>
    </div>
</x-app-layout>
