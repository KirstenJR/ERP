<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Usuarios</h2>
            <a href="{{ route('users.create') }}"
               class="rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-gray-700">
                Nuevo usuario
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
                            <th class="px-4 py-3">Nombre</th>
                            <th class="px-4 py-3">Correo</th>
                            <th class="px-4 py-3">Rol</th>
                            <th class="px-4 py-3">Coches</th>
                            <th class="px-4 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($users as $user)
                            <tr>
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $user->name }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $user->email }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $user->role }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $user->cars_count }}</td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('users.edit', $user) }}" class="text-indigo-600 hover:underline">Editar</a>
                                    @if ($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('users.destroy', $user) }}" class="ml-3 inline"
                                              onsubmit="return confirm('¿Eliminar a {{ $user->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
 
            <div class="mt-4">{{ $users->links() }}</div>
        </div>
    </div>
</x-app-layout>
