<?php 

namespace App\Functional\Helper;

class Helper{
    public static function emptyCheck($value , $default = null){
        if(empty($value)){
            return $default;
        }else{
            return $value;
        }
    }

    public static function endDateFilterTypeCreator(string $filterType){
        if($filterType == 'equal'){
            return '=';
        }elseif($filterType == 'equal_and_greater'){
            return '>=';
        }elseif($filterType == 'equal_and_smaller'){
            return '<=';
        }elseif($filterType == 'not_equal'){
            return '!=';
        }elseif($filterType == 'greater'){
            return '>';
        }elseif($filterType == 'smaller'){
            return false;
        }
    }
}