<?php
class DataController extends BaseController {

    public function index(){
        return 'Hi! Welcome to the <em>trak</em>suit endpoint.';
    }

    public function store(){
        $data = new Data();
        $data->key = Request::get('key');
        $data->value = Request::get('value');
        $data->save();
        return Response::json(array(
            'error' => false,
            'data' => $data->toArray()),
            200
        );
    }

    public function storeGet($key, $value){
        $data = new Data();
        $data->key = $key;
        $data->value = $value;
        $data->save();
        return Response::json(array(
            'error' => false,
            'data' => $data->toArray()),
            200
        );
    }


    public function show($key){
        $data = Data::where('key', '=', $key)->orderBy('id', 'DESC')->get();
        return Response::json($data->toArray());
    }

}
