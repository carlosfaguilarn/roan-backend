<?php

namespace Roan\Http\Controllers;

use Illuminate\Http\Request;
use Roan\Ad;

class AdController extends Controller{
    public function index(){
        return response()->json(["anuncios" => Ad::All()], 200);
    }
    public function store(Request $request){

      if($created = Ad::create($request->all())){
          return response()->json(["message" => "Anuncion creado correctamente", "created" => $created], 200);
      }else{
          return response()->json(["message" => "Hubo un error al guardar el anuncio"], 500);
      }
    }
}
