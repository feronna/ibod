<?php

namespace app\models;

use app\models\hronline\Department;
use app\models\hronline\Tblprcobiodata;
use app\models\system_core\ExternalUser;
use Exception;
use Yii;

class UtilitiesFunc
{

    public static function Internal($var)
    {
        $v = false;
        $model = Tblprcobiodata::find()->where(['ICNO' => $var])->andWhere(['!=', 'Status', '6'])->exists();
        if ($model) {
            $v = true;
        }
        return $v;
    }
    public static function External($var)
    {
        $v = false;
        $model = ExternalUser::find()->where(['user_id' => $var])->exists();
        if ($model) {
            $v = true;
        }
        return $v;
    }

    /**
     * get country list from api request
     * 
     * outpun json
     */
    public static function CountryList()
    {

        $api_url = 'https://registrar.ums.edu.my/staff/web/api/staff/country-list';

        // Read JSON file
        $json_data = file_get_contents($api_url);

        // Decode JSON data into PHP array
        $response_data = json_decode($json_data);

        return $response_data;
    }

    /**
     * get department list from api request
     * 
     * outpun json
     */
    public static function DepartmentList()
    {

        $api_url = 'https://registrar.ums.edu.my/staff/web/api/staff/dept-list';

        // Read JSON file
        $json_data = file_get_contents($api_url);

        // Decode JSON data into PHP array
        $response_data = json_decode($json_data);

        return $response_data;
    }

    public static function changeDateFormat($date, $format = null)
    {

        if (!$format) {
            $format = "d/m/Y";
        }

        $dt = date_create($date);

        $v = date_format($dt, "d/m/Y");

        return $v;
    }

    public static function totalStaffByDept($deptId)
    {
        $total = 0;

        $model = Tblprcobiodata::find()->joinWith(['jawatan b'])->where(['deptId' => $deptId, 'Status' => 1])->andWhere(['!=', 'b.gred', 'DA41'])->count();

        if ($model) {
            $total = $model;
        }

        return $total;
    }

    public static function kiraPeratus(int $total, int $full,int $deci=null){

        $percent = 0;

        if(!$deci){
            $deci = 2;
        }

        if($total > 0 && $full >0){
                $kira = ($total/$full)*100;
                $percent = round($kira,$deci);

        }

        return $percent;
    }

    /**
     * do the math
     * pass in the array of values and the quartile you are looking
     * @param $Array array type must be integer
     * @param $Quartile 0.25 | 0.5 | 0.75
     */
    // public static function Quartile($Array, $Quartile) {
    //     // quartile position is number in array + 1 multiplied by the quartile i.e. 0.25, 0.5, 0.75
    //     $pos = (count($Array) + 1) * $Quartile;
    
    //     // if the position is a whole number
    //     // return that number as the quarile placing
    //     if ( fmod($pos, 1) == 0)
    //     {
    //         return $Array[$pos];
    //     }
    //     else
    //     {
    //         // get the decimal i.e. 5.25 = .25
    //         $fraction = $pos - floor($pos);
    
    //         // get the values in the array before and after position
    //         $lower_num = $Array[floor($pos)-1];
    //         $upper_num = $Array[ceil($pos)-1];
    
    //         // get the difference between the two
    //         $difference = $upper_num - $lower_num;
        
    //         // the quartile value is then the difference multipled by the decimal
    //         // add to the lower number
    //         return round($lower_num + ($difference * $fraction),2);
    //     }

    // }

    public static function Quartile($Array, $Quartile) {
        sort($Array);
        $pos = (count($Array) - 1) * $Quartile;
      
        $base = floor($pos);
        $rest = $pos - $base;
      
        if( isset($Array[$base+1]) ) {
          return $Array[$base] + $rest * ($Array[$base+1] - $Array[$base]);
        } else {
          return $Array[$base];
        }
      }
}
