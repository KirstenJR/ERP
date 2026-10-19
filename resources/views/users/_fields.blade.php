@php($user = $user ?? null)
 
<div>
    <x-input-label for="name" value="Nombre" />
    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                  :value="old('name', $user?->name)" required autofocus />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>
 
<div class="mt-4">
    <x-input-label for="email" value="Correo" />
    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                  :value="old('email', $user?->email)" required />
    <x-input-error :messages="$errors->get('email')" class="mt-2" />
</div>
 
<div class="mt-4">
    <x-input-label for="role" value="Rol" />
    <select id="role" name="role"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        @foreach (['operador' => 'Operador', 'admin' => 'Administrador'] as $value => $label)
            <option value="{{ $value }}" @selected(old('role', $user?->role ?? 'operador') === $value)>{{ $label }}</option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('role')" class="mt-2" />
</div>
 
<div class="mt-4">
    <x-input-label for="password" value="Contraseña" />
    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"
                  autocomplete="new-password" />
    <x-input-error :messages="$errors->get('password')" class="mt-2" />
    @if ($user)
        <p class="mt-1 text-xs text-gray-500">Déjala vacía para conservar la actual.</p>
    @endif
</div>
 
<div class="mt-4">
    <x-input-label for="password_confirmation" value="Confirmar contraseña" />
    <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                  class="mt-1 block w-full" autocomplete="new-password" />
</div>
