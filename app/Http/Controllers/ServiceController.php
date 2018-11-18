<?php

namespace Roan\Http\Controllers;


use Roan\Http\Requests;
use Illuminate\Routing\Route;

use Illuminate\Http\Request;
use Roan\Http\Controllers\Controller;
use Roan\Service;

class ServiceController extends Controller {
    public function index(){
        $service = Service::all();
        return response()->json([
            "services" => $service->toArray()
        ]);
    }
    public function show($id) {}
    public function store() {}
}
