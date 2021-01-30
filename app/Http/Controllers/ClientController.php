<?php

namespace App\Http\Controllers;

use App\Client;
use App\City;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct()
    {

        $this->middleware("auth");

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clients;
        if($request->has('term')){
            $search = $request->term;            
            $clients = Client::orderBy('cod','ASC')->whereHas(
                'city_d', function ($query) use($search) {
                    $query->where('name', 'like',"%$search%");
                }
            )->paginate('5');
            return view("clients.index",compact('clients'));
        }else{
            $clients = Client::orderBy('cod','ASC')->paginate('5');
            return view("clients.index",compact('clients'));
        }
        
       
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
            'name' => 'required|string',
            'city' => 'required'
        ], [
            'cod.unique' => 'El codigo ingresado ya existe!',
            'cod.required' => 'Es necesario ingresar el codigo!',
            'city.required' => 'Es necesario seleccionar la ciudad!',
            'cod.numeric' => 'El codigo debe ser numerico!',
            'name.required' => 'Es necesario ingresar nombre del clliente!'
        ]);
        $client = new Client($request->input());
        $client->saveOrFail();
        return redirect()->route("clients.index")->with(["mensaje" => "Cliente ingresado correctamente",
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return ["client" => $client];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required|string',
            'city' => 'required'
        ], [            
            'city.required' => 'Es necesario seleccionar la ciudad!',
            'name.required' => 'Es necesario ingresar nombre del clliente!'
        ]);
        $client = Client::findOrFail($request->cod);
        $client->fill($request->input())->saveOrFail();
        return redirect()->route("clients.index")->with(["mensaje" => "Cliente actualizado correctamente."]);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        print_r($client);
        $client->delete();
        return redirect()->route("clients.index")->with(["mensaje" => "Cliente eliminado correctamente",
        ]);
    }
}
