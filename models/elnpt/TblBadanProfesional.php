<?php

namespace app\models\elnpt;
//
use Yii;
//use yii\helpers\Html;
//use app\models\hronline\BadanProfesional;
//use app\models\hronline\TarafKeahlian;

use app\models\hronline\TblBadanProfesional as BaseBadanProfesional;


/**
 * This is the model class for table "hronline.tblprprofassoc".
 *
 * @property string $profId
 * @property string $ICNO
 * @property string $ProfBodyCd
 * @property string $ProfBodyOther
 * @property string $MembershipTypeCd
 * @property string $JoinDt
 * @property string $FeeAmt
 * @property string $Designation
 * @property string $ResignDt
 * @property int $ProfAssocStatus
 */
class TblBadanProfesional extends BaseBadanProfesional
{    
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
}
