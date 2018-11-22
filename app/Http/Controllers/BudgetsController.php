<?php

namespace Roan\Http\Controllers;

use Illuminate\Http\Request;
use Roan\Budget;
use DB;

class BudgetsController extends Controller{
    public function index(){
      $presupuestos['presupuestos'] = Budget::All();
      $presupuestos['aprobados'] = DB::table('budgets')
          ->select(DB::raw('COUNT(*) as aprobados'))->where('status', '=', 'APROBADO')->get()[0]->aprobados;
      $presupuestos['rechazados'] = DB::table('budgets')
          ->select(DB::raw('COUNT(*) as rechazados'))->where('status', '=', 'RECHAZADO')->get()[0]->rechazados;
      $presupuestos['total'] = DB::table('budgets')
          ->select(DB::raw('COUNT(*) as total'))->get()[0]->total;

      return response()->json([
        "presupuestos" => Budget::budgets(),
        "aprobados" => $presupuestos['aprobados'],
        "rechazados" => $presupuestos['rechazados'],
        "total" => $presupuestos['total']
      ], 200);
    }
    public function saveBudget(Request $request){
      $presupuesto = new Budget;
      $presupuesto->descripcion = $request->input("descripcion");
      $presupuesto->proyecto_id = $request->input("proyecto_id");
      $presupuesto->cliente = $request->input("cliente");
      $presupuesto->url = $request->input("url");
      $presupuesto->proyecto = $request->input("proyecto");

      if($presupuesto->save())
          return response()->json(["message"=>"Presupuesto agregado exitosamente"], 200);
      else
          return response()->json(["message"=>"Hubo un error al agregar el presupuesto"], 500);
    }
    public function status(Request $request){
        $updated = DB::table('budgets')->where('budgets.id', '=', $request->input('id'))->update(['status' => $request->input('status')]);
        if(isset($updated))
            return response()->json(["message"=>"Status modificado correctamente"], 200);
        else
            return response()->json(["error"=>"Hubo un error al modificar el status"], 500);
    }
}
