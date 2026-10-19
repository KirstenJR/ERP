<?php
 
namespace App\Http\Controllers;
 
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
 
class CarController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
 
        $query = Car::with('user')->latest('fecha_inicio');
 
        // El operador solo ve sus coches; el admin ve todos.
        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }
 
        $cars = $query->paginate(10);
 
        return view('cars.index', compact('cars'));
    }
 
    public function create(Request $request)
    {
        $users = $this->usuariosParaSelector($request);
 
        return view('cars.create', compact('users'));
    }
 
    public function store(StoreCarRequest $request)
    {
        $data = $request->validated();
 
        if ($request->user()->role !== 'admin') {
            $data['user_id'] = $request->user()->id;
        } else {
            $data['user_id'] = $data['user_id'] ?? $request->user()->id;
        }
 
        Car::create($data);
 
        return redirect()->route('cars.index')->with('status', 'Coche registrado correctamente.');
    }
 
    public function edit(Request $request, Car $car)
    {
        Gate::authorize('update', $car);
 
        $users = $this->usuariosParaSelector($request);
 
        return view('cars.edit', compact('car', 'users'));
    }
 
    public function update(UpdateCarRequest $request, Car $car)
    {
        Gate::authorize('update', $car);
 
        $data = $request->validated();
 
        // Un operador no puede reasignar el coche a otro usuario.
        if ($request->user()->role !== 'admin') {
            unset($data['user_id']);
        } elseif (empty($data['user_id'])) {
            unset($data['user_id']);
        }
 
        $car->update($data);
 
        return redirect()->route('cars.index')->with('status', 'Coche actualizado correctamente.');
    }
 
    public function destroy(Car $car)
    {
        Gate::authorize('delete', $car);
 
        $car->delete();
 
        return redirect()->route('cars.index')->with('status', 'Coche eliminado correctamente.');
    }
 
    private function usuariosParaSelector(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return collect();
        }
 
        return User::orderBy('name')->get(['id', 'name']);
    }
}
