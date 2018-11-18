<?php

namespace Roan\Http\Controllers;

use Illuminate\Http\Request;
use Roan\Client;
use DB;

class ClientController extends Controller{
    public function index(){
        $clients['activos'] = DB::table('clients')
          ->select('clients.id', 'clients.name')->join('projects', 'projects.cliente', '=', 'clients.id')
          ->distinct('id')->get();

        $clients['inactivos'] = DB::table('clients')
          ->select('clients.id', 'clients.name')->leftJoin('projects', 'projects.cliente', '=', 'clients.id')

          ->where('projects.cliente')
          ->distinct('id')->get();

        return response()->json([
            "clients" => Client::All(),
            "activos" => $clients['activos'],
            "inactivos" => $clients['inactivos']
        ]);
    }
    public function store(Request $request){
        Client::create($request->all());
        return response()->json([
            "message" => "Cliente guardado correctamente"
        ], 200);
    }

    public function edit(Request $request){
        $cliente = Client::find($request->id);
        $cliente->name = $request->input('name');
        $cliente->telefono = $request->input('telefono');
        $cliente->direccion = $request->input('direccion');
        $cliente->email = $request->input('email');

        if($cliente->save()) {
            return response()->json(["message" => "Cliente editado correctamente"], 200);
        }else{
            return response()->json(["message" => "Error al editar al cliente"], 500);
        }
    }
}
