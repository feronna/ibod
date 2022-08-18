<?php

namespace app\commands;

//use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use app\models\cuti\CutiRekod;
use app\models\hronline\Tblprcobiodata;

class CutiController extends Controller {

    /**
     * 
     * @param type $date ni adalah tarikh sekiranya ada cuti yang baru yg kena umum oleh kerajaan
     * @return type
     */
    public function actionResetTempoh($date) {

//        $date = '2019-12-24';

        $sql = 'SELECT * FROM e_cuti.cuti_rekod WHERE :date BETWEEN cuti_mula and cuti_tamat AND cuti_jenis_id IN (1,2)';
        $rekod = CutiRekod::findBySql($sql, [':date' => $date])->all();


        foreach ($rekod as $r) {
            $campus_id = Tblprcobiodata::findOne(['ICNO' => $r->cuti_icno])->campus_id;

            $cuti = CutiRekod::findOne($r->cuti_rekod_id);
            $cuti->cuti_tempoh = CutiRekod::kiraTempoh($r->cuti_mula, $r->cuti_tamat, $campus_id);
            $cuti->save(false);

                echo $r->cuti_icno . "[" . $campus_id . "]|" . $r->cuti_mula . "|" . $r->cuti_tamat . "|" . $r->cuti_tempoh . "|" . CutiRekod::kiraTempoh($r->cuti_mula, $r->cuti_tamat, $campus_id) . "\n";
            
        }

        return ExitCode::OK;
    }

}
