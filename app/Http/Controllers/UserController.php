<?php
namespace Roan\Http\Controllers;

use Illuminate\Http\Request;
use Roan\Mail\Contacto;

use Roan\User;
use Illuminate\Support\Facades\Validator;
use Caffeinated\Shinobi\Models\Role;
use Caffeinated\Shinobi\Models\Permission;
use Hash;
use DB;
use Mail;

class UserController extends Controller{
    public function index(){
        $users = User::users();
        return response()->json([
          "users" => $users
        ]);
    }
    public function store(Request $request){
        $data = $request->all();

        $data['password'] =  Hash::make($request->input('password'));
        if($user = User::create($data)){
            return response()->json(["message" => "Usuario creado correctamente", "user" => $user], 200);
        }else{
            return response()->json(["error" => "Hubo un error al crear un usuario"], 500);
        }
    }
    public function roles(){
        $roles = Role::all();
        return response()->json([
          "roles" => $roles
        ]);
    }
    public function permisos(){
        $permisos = Permission::all();
        return response()->json([
          "permisos" => $permisos
        ]);
    }
    public static function permisos_por_rol(Request $request){
      $id_rol = $request->id_rol;
      $response_slug = array();
      $response_name = array();
      $response_descripcion = array();

      if($id_rol == '1'){
          $slugs        = DB::table('permissions')->select('permissions.slug as slugs')->get();
          $names        = DB::table('permissions')->select('permissions.name as names')->get();
          $description  = DB::table('permissions')->select('permissions.description as description')->get();
      }else{
          $slugs = DB::table('permission_role')
            ->join('permissions', 'permissions.id', '=', 'permission_role.permission_id')
            ->select('permissions.slug as slugs')->where('permission_role.role_id', $id_rol)->get();
          $names = DB::table('permission_role')
            ->join('permissions', 'permissions.id', '=', 'permission_role.permission_id')
            ->select('permissions.name as name')->where('permission_role.role_id', $id_rol)->get();
          $description = DB::table('permission_role')
            ->join('permissions', 'permissions.id', '=', 'permission_role.permission_id')
            ->select('permissions.description as description')->where('permission_role.role_id', $id_rol)->get();
      }
      foreach ($slugs as $slug)             foreach ($slug as $value) array_push($response_slug, $value);
      foreach ($names as $name)             foreach ($name as $value) array_push($response_name, $value);
      foreach ($description as $description) foreach ($description as $value) array_push($response_descripcion, $value);

      return response()->json([
        "permisos" => $response_slug,
        "name" => $response_name,
        "description" => $response_descripcion
      ], 200);
    }
    public function crear_rol(Request $request){
        $rol = new Role;
        $rol->name = $request->input("name");
        $rol->slug = $request->input("slug");
        $rol->description = $request->input("descripcion");
        if($rol->save()){
            return response()->json(["message"=>"Rol agregado exitosamente"], 200);
        }else{
            return response()->json(["message"=>"Hubo un error al agregar el rol"], 500);
        }
    }
    public function asignar_rol(Request $request){
        $id_usuario = $request->input("id_usuario");
        $id_rol     = $request->input("id_rol");

        DB::table('users')
            ->where('id', $id_usuario)
            ->update(['id_rol' => $id_rol]);


        return response()->json([
            "message" => "Rol asignado correctamente"
        ], 200);
    }
    public function quitar_rol(Request $request){
        $id_usuario = $request -> input("id_usuario");
        $id_rol     = $request -> input("id_rol");

        $usuario = User::find($id_usuario);
        $usuario->revokeRole($id_rol);
        $usuario = User::find($id_usuario);

        $roles_del_usuario = $usuario->getRoles();
        return response()->json([
            "roles" => $roles_del_usuario
        ]);
    }
    public function crear_permiso(Request $request){
        $permiso = new Permission;
        $permiso->name = $request->input("name");
        $permiso->slug = $request->input("slug");
        $permiso->description = $request->input("description");
        if($permiso->save()){
            return response()->json(["message" => "Permiso creado existosamente"], 200);
        }else{
            return response()->json(["message" => "Hubo un error al crear el permiso"], 500);
        }
    }
    public function asignar_permiso(Request $request){
        $id_rol = $request->input("id_rol");
        $id_permiso=$request->input("id_permiso");

        $rol = Role::find($id_rol);
        $rol->assignPermission($id_permiso);

        if($rol->save()){
            return response()->json(["message" => "Permiso asignado existosamente"], 200);
        }else{
            return response()->json(["message" => "Hubo un error al asignar el permiso"], 500);
        }
    }

    public function enviarEmailContacto(Request $request){
        /*Mail::send('contacto', $request->all(), function($msj){
          $msj->subject('Correo de contacto');
          $msj->to('roan.proyectos@gmail.com');
        });
        return response()->json(["message"=> "Mensaje enviado correctamente"], 200);*/


        $emailRoan = 'proyectos.roan@gmail.com';
        $mensaje = $request->input('mensaje');
        // título
        $titulo = 'Cliente';
        // Mensaje
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'From: Jobber <carlosf.aguilarn@gmail.com>' . "\r\n";

        //if(Mail::to($emailRoan)->send(new Contacto($request->input('mensaje')))){
        if(mail($emailRoan, $titulo, $mensaje, $cabeceras)){
            response()->json(["message"=> "Mensaje enviado correctamente"], 200);
        } else {
            response()->json(["error"=> "Ocurrió un error al enviar el mensaje"], 500);
        }
    }
}
