<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\User;

class ReportController extends Controller
{
    
private function filtros(Request $request): array
    {
        return $request->validate([
            'user_id' => ['nullable', 'exists:users,id'],
            'desde'   => ['nullable', 'date'],
            'hasta'   => ['nullable', 'date', 'after_or_equal:desde'],
        ], [
            'hasta.after_or_equal' => 'La fecha final no puede ser anterior a la inicial.',
        ]);
    }
 
    private function consulta(array $filtros)
    {
        return Car::with('user')
            ->when(! empty($filtros['user_id']), fn ($q) => $q->where('user_id', $filtros['user_id']))
            ->when(! empty($filtros['desde']), fn ($q) => $q->whereDate('fecha_inicio', '>=', $filtros['desde']))
            ->when(! empty($filtros['hasta']), fn ($q) => $q->whereDate('fecha_inicio', '<=', $filtros['hasta']))
            ->latest('fecha_inicio');
    }
 
    public function index(Request $request)
    {
        $filtros = $this->filtros($request);
        $query = $this->consulta($filtros);
 
        $total = (clone $query)->count();
 
        $porOperador = (clone $query)
            ->reorder()
            ->selectRaw('user_id, COUNT(*) as total')
            ->groupBy('user_id')
            ->get();
 
        $cars = $query->paginate(15)->withQueryString();
        $users = User::orderBy('name')->get(['id', 'name']);
 
        return view('reports.index', compact('cars', 'total', 'porOperador', 'users', 'filtros'));
    }
}

