<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarRequest;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function list(Request $request){
        $cars=Car::query()->join('clients','cars.clients_id','=','clients.id');

        if($request->filled('search')){
            $search=$request->input('search');
            $cars->where('model','LIKE','%'.$search.'%')
                ->orWhere('color','LIKE','%'.$search.'%')
                ->orWhere('license_plate','LIKE','%'.$search.'%')
                ->orWhere('clients.name','LIKE','%'.$search.'%');
                
        }

        return response()->json([
            'status' => 'success',
            'cars' => $cars->with('client')->get(),
        ]);
    }

    public function add(CarRequest $request){
        $car=new Car();
        $car->model=$request->input('model');
        $car->color=$request->input('color');
        $car->license_plate=$request->input('license_plate');
        $car->clients_id=$request->input('clients_id');
        $car->save();

        return response()->json([
            'status' => 'success',
            'car' => $car,
        ]);
    }
    
}
