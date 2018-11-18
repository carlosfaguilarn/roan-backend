<?php

namespace Roan\Http\Controllers;

use Illuminate\Http\Request;
use Roan\Org;

class OrgController extends Controller{
    public function index(){
        return response()->json([
          "org" => Org::All()->first()
        ]);
    }
}
