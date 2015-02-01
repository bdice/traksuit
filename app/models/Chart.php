<?php
 
class Chart extends Eloquent {

    protected $table = 'charts';

    public function getSensor1(){
        return $this->attributes['sensor1'];
    }

    public function getSensor2(){
        return $this->attributes['sensor2'];
    }

}