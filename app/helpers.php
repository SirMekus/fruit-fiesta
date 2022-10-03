<?php
use Carbon\Carbon;

function carbon($date_time){
	return new Carbon($date_time);
}

function createMatrix($column, $row, $min=1, $max=15){
    $matrix= [];

    while(count($matrix) < $row){
        
        $matrix_column = [];
        
        while(count($matrix_column) < $column){
            $matrix_column []= rand($min, $max);
        }

        $matrix [] = $matrix_column;
    }

    return $matrix;
}

?>