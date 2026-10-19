<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
        public function index()
    {
        $users = User::withCount('cars')->orderBy('name')->paginate(10);
 
        return view('users.index', compact('users'));
    }
 
    public function create()
    {
        return view('users.create');
    }
 
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
 
        // role no está en $fillable de User: se asigna de forma explícita.
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role = $data['role'];
        $user->password = Hash::make($data['password']);
        $user->save();
 
        return redirect()->route('users.index')->with('status', 'Usuario creado correctamente.');
    }
 
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }
 
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
 
        if ($user->id === $request->user()->id && $data['role'] !== 'admin') {
            return back()
                ->withInput()
                ->withErrors(['role' => 'No puedes quitarte tu propio rol de administrador.']);
        }

        if ($user->role === 'admin' && $data['role'] !== 'admin'
            && User::where('role', 'admin')->count() <= 1) {
            return back()
                ->withInput()
                ->withErrors(['role' => 'Debe existir al menos un administrador.']);
        }
 
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role = $data['role'];
 
        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
 
        $user->save();
 
        return redirect()->route('users.index')->with('status', 'Usuario actualizado correctamente.');
    }
 
    public function destroy(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return back()->with('status', 'No puedes eliminar tu propia cuenta.');
        }
 
        if ($user->cars()->exists()) {
            return back()->with('status', 'No se puede eliminar: el usuario tiene coches registrados.');
        }
 
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return back()->with('status', 'No se puede eliminar al único administrador.');
        }
 
        $user->delete();
 
        return redirect()->route('users.index')->with('status', 'Usuario eliminado correctamente.');
    }

}
