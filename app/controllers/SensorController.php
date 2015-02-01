<?php
class SensorController extends BaseController {

    public function index(){
        $data = Data::all();
        return Response::json($data->toArray());
    }

    public function show($key){
        $data = Data::where('key', '=', $key)->get();
        return Response::json($data->toArray());
    }

}
