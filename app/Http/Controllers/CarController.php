<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Car::with('user')->latest('fecha_inicio');

        if($user->role!=='admin'){
            $query->where('user_id',$user->id);
        }
        $cars=$query->paginate(10);
        return view('cars.index',compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $users = $this->usuariosParaSelector($request);

        return view('cars.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validated();

        if ($request->user()->role!=='admin'){
            $data['user_id']=$request->user()->id;
        }else{
            $data['user_id']=$data['user_id'] ?? $request->user()->id;
        }

        Car::create($data);

        return redirect()->route('cars.index')->with('status','Coche registrado correctamente');
    }

    private function usuariosParaSelector(Request $request)
    {
        if($request->user()->role !== 'admin'){
            return collect();
        }
        return User::orderBy('name')->get(['id','name']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        //
    }
}
