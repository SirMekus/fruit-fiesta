<?php

namespace App\Services;
use App\Models\Symbol;
use Illuminate\Support\Arr;

class Matrix
{
    public function createMatrix(int $column=5, int $row=3) : array
    {
        $symbols = Symbol::limit(15)->inRandomOrder()->get()->toArray();

        //dd($symbols->toArray());

        $matrix= [];

        // while(count($matrix) < $row){
        //     $matrix [] = $symbol->random($column)->toArray();
        // }
        //dd(collect($matrix)->unique());
    
        while(count($matrix) < $row){
            
            $matrix_column = [];
            
            while(count($matrix_column) < $column){
                $random_index = array_rand($symbols);

                $matrix_column []= $symbols[$random_index];
            }
    
            $matrix [] = $matrix_column;
        }
        //dd($matrix);
    
        return $matrix;
    }

    public function uniqueElements(array $matrix): array
    {
        $unique = [];

        $found = [];

        $i = 0;

        $row_count = count($matrix);

        while($i < $row_count){
            $column_count =  count($matrix[$i]);
            for($column=0;$column < $column_count;$column++){
                if(!in_array($matrix[$i][$column]['id'], $found)){
                    $unique []= $matrix[$i][$column];
                    $found []= $matrix[$i][$column]['id'];
                }
            }
            $i++;
        }

        return $unique;
    }

    public function calculatePoints(array $matrix): int|float
    {
        $total = 0;

        $winning_symbols = [];

        $unique = $this->uniqueElements($matrix);

        $combined = Arr::collapse($matrix);
        
        for($i=0;$i<count($unique);$i++){
            if($this->checkFiveMatches($combined, $unique[$i]) > 0){
                $total += $this->checkFiveMatches($combined, $unique[$i]);
                $winning_symbols []= $unique[$i];
            }
            else if($this->checkFourMatches($combined, $unique[$i]) > 0){
                $total += $this->checkFourMatches($combined, $unique[$i]);
                $winning_symbols []= $unique[$i];
            }
            else if($this->checkThreeMatches($combined, $unique[$i]) > 0){
                $total += $this->checkThreeMatches($combined, $unique[$i]);
                $winning_symbols []= $unique[$i];
            }
        }

        return $total;
    }

    public function checkThreeMatches(array $matrix, array $needle): int|float
    {
        $point = 0;

        /* Case 1st item */
        //1-2-3
        if(($matrix[0]['id'] == $matrix[1]['id']) and ($matrix[1]['id'] == $matrix[2]['id']) and ($matrix[2]['id']== $needle['id'])){
            $point += $needle['three_match'];
        }
        //1-2-8
        if(($matrix[0]['id'] == $matrix[1]['id']) and ($matrix[1]['id'] == $matrix[7]['id']) and ($matrix[7]['id']== $needle['id'])){
            $point += $needle['three_match'];
        }
        //1-7-13
        if(($matrix[0]['id'] == $matrix[6]['id']) and ($matrix[6]['id'] == $matrix[12]['id']) and ($matrix[12]['id']== $needle['id'])){
            $point += $needle['three_match'];
        }

        /* Case 2nd item */
        // 2-3-4
        if(($matrix[1]['id'] == $matrix[2]['id']) and ($matrix[2]['id'] == $matrix[3]['id']) and ($matrix[3]['id']== $needle['id'])){
            $point += $needle['three_match'];
        }
        //2-8-14
        if(($matrix[1]['id'] == $matrix[7]['id']) and ($matrix[7]['id'] == $matrix[13]['id']) and ($matrix[13]['id']== $needle['id'])){
            $point += $needle['three_match'];
        }

        /* Case 3rd item */
        //3-4-5
        if(($matrix[2]['id'] == $matrix[3]['id']) and ($matrix[3]['id'] == $matrix[4]['id']) and ($matrix[4]['id']== $needle['id'])){
            $point += $needle['three_match'];
        }
        //3-4-10
        if(($matrix[2]['id'] == $matrix[3]['id']) and ($matrix[3]['id'] == $matrix[9]['id']) and ($matrix[9]['id']== $needle['id'])){
            $point += $needle['three_match'];
        }

        /* Case 6th item */
        //6-7-8
        if(($matrix[5]['id'] == $matrix[6]['id']) and ($matrix[6]['id'] == $matrix[7]['id']) and ($matrix[7]['id']== $needle['id'])){
            $point += $needle['three_match'];
        }
        //6-2-3
        if(($matrix[5]['id'] == $matrix[1]['id']) and ($matrix[1]['id'] == $matrix[2]['id']) and ($matrix[2]['id']== $needle['id'])){
            $point += $needle['three_match'];
        }
        //6-12-13
        if(($matrix[5]['id'] == $matrix[11]['id']) and ($matrix[11]['id'] == $matrix[12]['id']) and ($matrix[12]['id']== $needle['id'])){
            $point += $needle['three_match'];
        }

        /* Case 7th item */
        //7-8-9
        if(($matrix[6]['id'] == $matrix[7]['id']) and ($matrix[7]['id'] == $matrix[8]['id']) and ($matrix[8]['id']== $needle['id'])){
            $point += $needle['three_match'];
        }
        //7-13-9
        if(($matrix[6]['id'] == $matrix[12]['id']) and ($matrix[12]['id'] == $matrix[8]['id']) and ($matrix[8]['id']== $needle['id'])){
            $point += $needle['three_match'];
        }
        //7-3-9
        if(($matrix[6]['id'] == $matrix[2]['id']) and ($matrix[2]['id'] == $matrix[8]['id']) and ($matrix[8]['id']== $needle)){
            $point += $needle['three_match'];
        }

        /* Case 8th item */
        //8-9-10
        if(($matrix[7]['id'] == $matrix[8]['id']) and ($matrix[8]['id'] == $matrix[9]['id']) and ($matrix[9]['id']== $needle['id'])){
            $point += $needle['three_match'];
        }
        //8-14-15
        if(($matrix[7]['id'] == $matrix[13]['id']) and ($matrix[13]['id'] == $matrix[14]['id']) and ($matrix[14]['id']== $needle['id'])){
            $point += $needle['three_match'];
        }
        //8-4-5
        if(($matrix[7]['id'] == $matrix[3]['id']) and ($matrix[3]['id'] == $matrix[4]['id']) and ($matrix[4]['id']== $needle['id'])){
            $point += $needle['three_match'];
        }

        /* Case 11th item */
        //11-12-13
        if(($matrix[10]['id'] == $matrix[11]['id']) and ($matrix[11]['id'] == $matrix[12]['id']) and ($matrix[12]['id']== $needle['id'])){
            $point += $needle['three_match'];
        }
        //11-7-3
        if(($matrix[10]['id'] == $matrix[6]['id']) and ($matrix[6]['id'] == $matrix[2]['id']) and ($matrix[2]['id']== $needle['id'])){
            $point += $needle['three_match'];
        }
        //11-12-8
        if(($matrix[10]['id'] == $matrix[11]['id']) and ($matrix[11]['id'] == $matrix[7]['id']) and ($matrix[7]['id']== $needle['id'])){
            $point += $needle['three_match'];
        }

        /* Case 12th item */
        //12-13-14
        if(($matrix[11]['id'] == $matrix[12]['id']) and ($matrix[12]['id'] == $matrix[13]['id']) and ($matrix[13]['id']== $needle['id'])){
            $point += $needle['three_match'];
        }
        //12-8-4
        if(($matrix[11]['id'] == $matrix[7]['id']) and ($matrix[7]['id'] == $matrix[3]['id']) and ($matrix[3]['id']== $needle['id'])){
            $point += $needle['three_match'];
        }

        /* Case 13th item */
        //13-14-15
        if(($matrix[12]['id'] == $matrix[13]['id']) and ($matrix[13]['id'] == $matrix[14]['id']) and ($matrix[14]['id']== $needle['id'])){
            $point += $needle['three_match'];
        }
        //13-9-5
        if(($matrix[12]['id'] == $matrix[8]['id']) and ($matrix[8]['id'] == $matrix[4]['id']) and ($matrix[4]['id']== $needle['id'])){
            $point += $needle['three_match'];
        }
        //13-14-10
        if(($matrix[12]['id'] == $matrix[13]['id']) and ($matrix[13]['id'] == $matrix[9]['id']) and ($matrix[9]['id']== $needle['id'])){
            $point += $needle['three_match'];
        }

        //dump("3 point: {$point}");

        return $point;
    }

    public function checkFourMatches(array $matrix, array $needle): int|float
    {
        $point = 0;

        $matched_point = $needle['four_match'];

        /* Case 1st item */
        //1-2-3-4
        if(($matrix[0]['id'] == $matrix[1]['id']) and ($matrix[1]['id'] == $matrix[2]['id']) and ($matrix[2]['id'] == $matrix[3]['id']) and ($matrix[3]['id']== $needle['id'])){
            $point += $matched_point;
        }
        //1-2-8-14
        if(($matrix[0]['id'] == $matrix[1]['id']) and ($matrix[1]['id'] == $matrix[7]['id']) and ($matrix[7]['id'] == $matrix[13]['id']) and ($matrix[13]['id']== $needle['id'])){
            $point += $matched_point;
        }
        //1-7-13-9
        if(($matrix[0]['id'] == $matrix[6]['id']) and ($matrix[6]['id'] == $matrix[12]['id']) and ($matrix[12]['id']== $needle['id']) and ($matrix[12]['id'] == $matrix[8]['id'])){
            $point += $matched_point;
        }


        /* Case 2nd item */
        // 2-3-4-5
        if(($matrix[1]['id'] == $matrix[2]['id']) and ($matrix[2]['id'] == $matrix[3]['id']) and ($matrix[3]['id']== $needle['id']) and ($matrix[3]['id']== $matrix[4]['id'])){
            $point += $matched_point;
        }
        //2-8-14-15
        if(($matrix[1]['id'] == $matrix[7]['id']) and ($matrix[7]['id'] == $matrix[13]['id']) and ($matrix[13]['id']== $needle['id']) and ($matrix[13]['id']== $matrix[14]['id'])){
            $point += $matched_point;
        }


        /* Case 6th item */
        //6-7-8-9
        if(($matrix[5]['id'] == $matrix[6]['id']) and ($matrix[6]['id'] == $matrix[7]['id']) and ($matrix[7]['id']== $needle['id']) and ($matrix[7]['id']== $matrix[8]['id'])){
            $point += $matched_point;
        }
        //6-2-3-4
        if(($matrix[5]['id'] == $matrix[1]['id']) and ($matrix[1]['id'] == $matrix[2]['id']) and ($matrix[2]['id']== $needle['id']) and ($matrix[2]['id']== $matrix[3]['id'])){
            $point += $matched_point;
        }
        //6-12-13-14
        if(($matrix[5]['id'] == $matrix[11]['id']) and ($matrix[11]['id'] == $matrix[12]['id']) and ($matrix[12]['id']== $needle['id'])
        and ($matrix[12]['id']== $matrix[13]['id'])){
            $point += $matched_point;
        }


        /* Case 7th item */
        //7-8-9-10
        if(($matrix[6]['id'] == $matrix[7]['id']) and ($matrix[7]['id'] == $matrix[8]['id']) and ($matrix[8]['id']== $needle['id']) 
        and ($matrix[8]['id']== $matrix[9]['id'])){
            $point += $matched_point;
        }
        //7-13-9-5
        if(($matrix[6]['id'] == $matrix[12]['id']) and ($matrix[12]['id'] == $matrix[8]['id']) and ($matrix[8]['id']== $needle['id']) 
        and ($matrix[8]['id']== $matrix[4]['id'])){
            $point += $matched_point;
        }
        //7-3-9-15
        if(($matrix[6]['id'] == $matrix[2]['id']) and ($matrix[2]['id'] == $matrix[8]['id']) and ($matrix[8]['id']== $needle)
        and ($matrix[8]['id']== $matrix[14]['id'])){
            $point += $matched_point;
        }


        /* Case 11th item */
        //11-12-13-14
        if(($matrix[10]['id'] == $matrix[11]['id']) and ($matrix[11]['id'] == $matrix[12]['id']) and ($matrix[12]['id']== $needle['id'])
        and ($matrix[12]['id']== $matrix[13]['id'])){
            $point += $matched_point;
        }
        //11-7-3-9
        if(($matrix[10]['id'] == $matrix[6]['id']) and ($matrix[6]['id'] == $matrix[2]['id']) and ($matrix[2]['id']== $needle['id'])
        and ($matrix[2]['id']== $matrix[8]['id'])){
            $point += $matched_point;
        }
        //11-12-8-4
        if(($matrix[10]['id'] == $matrix[11]['id']) and ($matrix[11]['id'] == $matrix[7]['id']) and ($matrix[7]['id']== $needle['id'])
        and ($matrix[7]['id']== $matrix[3]['id'])){
            $point += $matched_point;
        }

        /* Case 12th item */
        //12-13-14-15
        if(($matrix[11]['id'] == $matrix[12]['id']) and ($matrix[12]['id'] == $matrix[13]['id']) and ($matrix[13]['id']== $needle['id'])
        and ($matrix[13]['id']== $matrix[14]['id'])){
            $point += $needle['three_match'];
        }
        //12-8-4-5
        if(($matrix[11]['id'] == $matrix[7]['id']) and ($matrix[7]['id'] == $matrix[3]['id']) and ($matrix[3]['id']== $needle['id']) 
        and ($matrix[3]['id']== $matrix[4]['id'])){
            $point += $needle['three_match'];
        }

        //dump("4 point: {$point}");

        return $point;
    }

    public function checkFiveMatches(array $matrix, array $needle): int|float
    {
        $point = 0;

        $matched_point = $needle['five_match'];

        /* Case 1st item */
        //1-2-3-4-5
        if(($matrix[0]['id'] == $matrix[1]['id']) and ($matrix[1]['id'] == $matrix[2]['id']) and ($matrix[2]['id'] == $matrix[3]['id'])
        and ($matrix[3]['id']== $needle['id']) and ($matrix[3]['id']== $matrix[4]['id'])){
            $point += $matched_point;
        }
        //1-2-8-14-15
        if(($matrix[0]['id'] == $matrix[1]['id']) and ($matrix[1]['id'] == $matrix[7]['id']) and ($matrix[7]['id'] == $matrix[13]['id']) 
        and ($matrix[13]['id']== $needle['id']) and ($matrix[13]['id']== $matrix[14]['id'])){
            $point += $matched_point;
        }
        //1-7-13-9-5
        if(($matrix[0]['id'] == $matrix[6]['id']) and ($matrix[6]['id'] == $matrix[12]['id']) and ($matrix[12]['id']== $needle['id'])
        and ($matrix[12]['id'] == $matrix[8]['id']) and ($matrix[8]['id'] == $matrix[4]['id'])){
            $point += $matched_point;
        }


        /* Case 6th item */
        //6-7-8-9-10
        if(($matrix[5]['id'] == $matrix[6]['id']) and ($matrix[6]['id'] == $matrix[7]['id']) and ($matrix[7]['id']== $needle['id'])
        and ($matrix[7]['id']== $matrix[8]['id']) and ($matrix[8]['id']== $matrix[9]['id'])){
            $point += $matched_point;
        }
        //6-2-3-4-10
        if(($matrix[5]['id'] == $matrix[1]['id']) and ($matrix[1]['id'] == $matrix[2]['id']) and ($matrix[2]['id']== $needle['id']) and ($matrix[2]['id']== $matrix[3]['id']) and ($matrix[3]['id']== $matrix[9]['id'])){
            $point += $matched_point;
        }
        //6-12-13-14-10
        if(($matrix[5]['id'] == $matrix[11]['id']) and ($matrix[11]['id'] == $matrix[12]['id']) and ($matrix[12]['id']== $needle['id'])
        and ($matrix[12]['id']== $matrix[13]['id']) and ($matrix[13]['id']== $matrix[9]['id'])){
            $point += $matched_point;
        }


        /* Case 11th item */
        //11-12-13-14-15
        if(($matrix[10]['id'] == $matrix[11]['id']) and ($matrix[11]['id'] == $matrix[12]['id']) and ($matrix[12]['id']== $needle['id'])
        and ($matrix[12]['id']== $matrix[13]['id']) and ($matrix[13]['id']== $matrix[14]['id'])){
            $point += $matched_point;
        }
        //11-7-3-9-15
        if(($matrix[10]['id'] == $matrix[6]['id']) and ($matrix[6]['id'] == $matrix[2]['id']) and ($matrix[2]['id']== $needle['id'])
        and ($matrix[2]['id']== $matrix[8]['id']) and ($matrix[8]['id']== $matrix[14]['id'])){
            $point += $matched_point;
        }
        //11-12-8-4-5
        if(($matrix[10]['id'] == $matrix[11]['id']) and ($matrix[11]['id'] == $matrix[7]['id']) and ($matrix[7]['id']== $needle['id'])
        and ($matrix[7]['id']== $matrix[3]['id']) and ($matrix[3]['id']== $matrix[4]['id'])){
            $point += $matched_point;
        }

        //dump("5 point: {$point}");

        return $point;
    }
}
