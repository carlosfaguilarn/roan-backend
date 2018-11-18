<?php
namespace Roan\Http\Controllers;

use Illuminate\Http\Request;

use Roan\User;
use Illuminate\Support\Facades\Validator;
use Caffeinated\Shinobi\Models\Role;
use Caffeinated\Shinobi\Models\Permission;
use DB;

class UserController extends Controller{
    public function index(){
        $users = User::users();
        return response()->json([
          "users" => $users
        ]);
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
      $response = array();

      $slugs = DB::table('permission_role')
        ->join('permissions', 'permissions.id', '=', 'permission_role.permission_id')
        ->select('permissions.slug as name')
        ->where('permission_role.role_id', $id_rol)
        ->get();

      foreach ($slugs as $slug) {
        foreach ($slug as $value) {
          array_push($response, $value);
        }
      }

      return response()->json([
        "permisos" => $response
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
}
