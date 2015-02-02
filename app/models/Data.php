<?php
 
class Data extends Eloquent {
 
    protected $table = 'data';

    public function getCreatedAtAttribute($value){
        $value = date('U', strtotime($value));
        return $value * 1000;
    }
 
}