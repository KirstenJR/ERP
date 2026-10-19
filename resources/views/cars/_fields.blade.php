@php($car = $car ?? null)
 
<div>
    <x-input-label for="matricula" value="Matrícula" />
    <x-text-input id="matricula" name="matricula" type="text" class="mt-1 block w-full"
                  :value="old('matricula', $car?->matricula)" required autofocus />
    <x-input-error :messages="$errors->get('matricula')" class="mt-2" />
</div>
 
<div class="mt-4">
    <x-input-label for="fecha_inicio" value="Fecha de inicio" />
    <x-text-input id="fecha_inicio" name="fecha_inicio" type="date" class="mt-1 block w-full"
                  :value="old('fecha_inicio', $car?->fecha_inicio?->format('Y-m-d'))" required />
    <x-input-error :messages="$errors->get('fecha_inicio')" class="mt-2" />
</div>
 
@if ($users->isNotEmpty())
    <div class="mt-4">
        <x-input-label for="user_id" value="Operador" />
        <select id="user_id" name="user_id"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @foreach ($users as $u)
                <option value="{{ $u->id }}" @selected((int) old('user_id', $car?->user_id ?? auth()->id()) === $u->id)>
                    {{ $u->name }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
    </div>
@endif
