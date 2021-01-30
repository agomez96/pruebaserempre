<?php

namespace App\Http\Controllers;

use App\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::orderBy('cod','ASC')->paginate('5');
        return view("cities.index",compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function selectcities(Request $request)
    {
    	$cities = [];

        if($request->has('q')){
            $search = $request->q;
            $cities =City::select("cod", "name")
            		->where('name', 'LIKE', "%$search%")
            		->get();
        }else{
            $cities =City::select("cod", "name")
            		->get();
        }
        return response()->json($cities);
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'cod' => 'required|numeric|unique:cities',
            'name' => 'required|string'
        ], [
            'cod.unique' => 'El codigo ingresado ya existe!',
            'cod.required' => 'Es necesario ingresar el codigo!',
            'cod.numeric' => 'El codigo debe ser numerico!',
            'name.required' => 'Es necesario ingresar nombre!'
        ]);
        $city = new City($request->input());
        $city->saveOrFail();
        return redirect()->route("cities.index")->with(["mensaje" => "Ciudad ingresada correctamente",
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        return ["city" => $city];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $city = City::findOrFail($request->cod);
        $city->fill($request->input())->saveOrFail();
        return redirect()->route("cities.index")->with(["mensaje" => "Ciudad actualizada correctamente."]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {   
      try{
        $city->delete();
        return redirect()->route("cities.index")->with(["mensaje" => "Ciudad eliminada correctamente",
        ]);
      }catch(\Illuminate\Database\QueryException $ex){ 
        return redirect()->route("cities.index")->with(["error" => "Existen usuarios con la ciudad que desea eliminar, primero actualice los usuarios a otra ciudad."]);
      }

        
    }
}
