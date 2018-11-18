<?php
namespace Roan\Http\Controllers;

use Illuminate\Http\Request;
use Roan\Project;
use Roan\Concept;
use DB;

class ProjectController extends Controller{
    public function index(){
        return response()->json([
            "projects" => Project::projects()['projects'],
            "activos"  => Project::projects()['activos']
        ],200);
    }
    public function getProject(Request $request){
      if(!$project = Project::project($request->id)){
          return response()->json(["error" => "Proyecto no encontrado"], 404);
      }else if(!isset($project->id)){
          return response()->json(["error" => $project], 500);
      }else{
        return response()->json(["proyecto" => $project], 200);
      }
    }
    public function conceptosProyecto(Request $request){
        $id_proyecto = $request->id_proyecto;
        $conceptos['concepts'] = DB::table('concepts')
                ->select('concepts.*')
                ->where('proyecto_id', $id_proyecto)
                ->get();
       $total_costo = DB::table('concepts')->where('proyecto_id', $id_proyecto)->sum('concepts.costo');
       $total_cobrado = DB::table('concepts')->where('proyecto_id', $id_proyecto)->where('fin', '<>', '')->sum('concepts.costo');

       $total_conceptos = DB::table('concepts')->where('proyecto_id', $id_proyecto)->count();
       $total_costo = DB::table('concepts')->where('proyecto_id', $id_proyecto)->sum('concepts.costo');
       $terminados = DB::table('concepts')->where('proyecto_id', $id_proyecto)->where('fin', '<>', '')->count();
       $conceptos['avance'] = $terminados / $total_conceptos * 100;
       $conceptos['total_pendiente'] =  $total_costo - $total_cobrado;
       $conceptos['total_cobrado'] = $total_cobrado;

        return response()->json([
            "conceptos" => $conceptos
        ],200);
    }
    public function nuevoConcepto(Request $request){
      $concepto = new Concept;
      $concepto->descripcion = $request->input("descripcion");
      $concepto->costo = $request->input("costo");
      $concepto->inicio = $request->input("inicio");
      $concepto->fin = $request->input("fin");
      $concepto->evidencia = $request->input("evidencia");
      $concepto->proyecto_id = $request->input("proyecto_id");

      if($concepto->save()){
          return response()->json([
            "message"=>"Tarea agregada exitosamente",
            "concept"=> $concepto
          ], 200);
      }else{
          return response()->json(["message"=>"Hubo un error al agregar la tarea"], 500);
      }
    }
    public function editarConcepto(Request $request){
      $concepto = Concept::find($request->input('id'));
      $concepto->inicio = $request->input('inicio');
      $concepto->fin = $request->input('fin');
      $concepto->evidencia = $request->input('evidencia');
      if($concepto->save()){
          return response()->json(["message"=>"Tarea editada correctamente"], 200);
      }else{
          return response()->json(["message"=>"Hubo un error al editar la tarea"], 500);
      }
    }
}
