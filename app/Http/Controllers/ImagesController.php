<?php


namespace Roan\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use DB;
use Illuminate\Support\Facades\Storage;

class ImagesController extends Controller{
    public function viewImage(Request $request){
        $imagen = $request->imagen;
        $storagePath = storage_path('/app/'.$imagen);
        return Image::make($storagePath)->response();
        //return response()->file($storagePath);
    }
    public function viewPDF(Request $request){
        $file = $request->pdf;
        $file = storage_path('/app/'.$file);
        return response()->file($file);
    }
    public function savePicture(Request $request){
       //obtenemos el campo file definido en el formulario
       $file = $request->file('img');
       //obtenemos el nombre del archivo
       $date = date('Y-m-d H_i_s');
       $string = str_replace(" ", "-", $date);
       $nombre = $string."-".$file->getClientOriginalName();
       $nombre = str_replace(" ", "_", $nombre);
       //indicamos que queremos guardar un nuevo archivo en el disco local
       \Storage::disk('local')->put($nombre,  \File::get($file));
       //Relacionar imagen con el concepto en la base de datos
       DB::table('concepts')->where('id', $request->input('id'))->update(['evidencia' => $nombre]);
       return response()->json([
         "img" => $nombre
       ], 200);
    }
    public function savePDF(Request $request){
       //obtenemos el campo file definido en el formulario
       $file = $request->file('pdf');
       //obtenemos el nombre del archivo
       $date = date('Y-m-d H_i_s');
       $string = str_replace(" ", "-", $date);
       $nombre = $string."presupuesto.pdf";//."-".$file->getClientOriginalName();
       $nombre = str_replace(" ", "_", $nombre);
       //indicamos que queremos guardar un nuevo archivo en el disco local
       \Storage::disk('local')->put($nombre,  \File::get($file));
       return response()->json([
         "pdf" => $nombre
       ], 200);
    }
}
