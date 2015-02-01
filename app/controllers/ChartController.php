<?php
class ChartController extends BaseController {

    protected $sensors;
    
    public function __construct(Sensors $sensors){
        $this->sensors = $sensors;
    }

    public function index(){
        $charts = Chart::all();
        $results = array();
        foreach ($charts as $chart) {
            $sensor1 = $this->sensors->find($chart->getSensor1())->getAttributes();
            $sensor2 = $this->sensors->find($chart->getSensor2())->getAttributes();
            $results[] = array($sensor1, $sensor2);
        }
        return Response::json($results);
    }

    public function store(){
        $chart = new Chart();
        $chart->sensor1 = Request::get('sensor1');
        $chart->sensor2 = Request::get('sensor2');
        $chart->save();
        return Response::json(array(
            'error' => false,
            'data' => $chart->toArray()),
            200
        );
    }

    public function show($id){
        $chart = Chart::find($id);
        $sensor1 = $this->sensors->find($chart->getSensor1())->getAttributes();
        $sensor2 = $this->sensors->find($chart->getSensor2())->getAttributes();
        return Response::json(array($sensor1, $sensor2));
    }

}
