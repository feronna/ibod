<?php

namespace app\models\elnpt;

use Yii;

use app\models\hronline\GredJawatan as BaseJawatan;

/**
 * This is the model class for table "hronline.gredJawatan".
 *
 * @property int $id
 * @property int $sbpa_id
 * @property string $nama
 * @property string $gred
 * @property string $fname
 * @property string $mymohesCd
 * @property string $short_desc
 * @property int $job_category
 * @property int $job_group kumpkhidmat
 * @property int $cpd_group idp.v_idp_kumpulan
 * @property string $SchmOfServCd
 * @property string $SalGrdId
 * @property int $gred_status
 * @property string $gred_skim
 * @property string $gred_no
 * @property string $idMM
 * @property int $isActive
 * @property int $isKhas
 * @property string $titleMM
 */
class GredJawatan extends BaseJawatan {

    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    
    //utk elnpt
    public static function findGred($gred)
    {
        return static::findOne([$gred]);
    }

}
