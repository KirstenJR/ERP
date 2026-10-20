<?php
 
namespace App\Http\Controllers;
 
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
 
class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $esAdmin = $user->role === 'admin';
 
        // Base: el admin ve todos los coches; el operador solo los suyos.
        $base = Car::query();
        if (! $esAdmin) {
            $base->where('user_id', $user->id);
        }
 
        $totalCoches = (clone $base)->count();
 
        $inicioMes = now()->startOfMonth()->toDateString();
        $finMes = now()->endOfMonth()->toDateString();
        $cochesDelMes = (clone $base)->whereBetween('fecha_inicio', [$inicioMes, $finMes])->count();
 
        $ultimos = (clone $base)->with('user')->latest('fecha_inicio')->limit(5)->get();
 
        // Solo para el admin.
        $totalUsuarios = null;
        $porOperador = collect();
 
        if ($esAdmin) {
            $totalUsuarios = User::count();
 
            $porOperador = User::withCount('cars')
                ->orderByDesc('cars_count')
                ->get(['id', 'name']);
        }
 
        return view('dashboard', compact(
            'esAdmin', 'totalCoches', 'cochesDelMes', 'ultimos', 'totalUsuarios', 'porOperador'
        ));
    }
}

