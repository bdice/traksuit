<?php
 
class Sensors extends Eloquent {
 
    protected $table = 'sensors';

    public function getAttributes(){
        return $this->attributes;
    }
 
}