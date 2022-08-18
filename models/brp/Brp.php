<?php

namespace app\models\brp;

use Yii;
use app\models\hronline\Tblprcobiodata;
use kartik\date\DatePicker;
/**
 * This is the model class for table "brp.brp".
 *
 * @property int $brpCd
 * @property string $brpTitle
 * @property string $brpBottomDesc
 */
class Brp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.brp_brp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['brpBottomDesc'], 'string'],
            [['brpTitle'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'brpCd' => 'Brp Cd',
            'brpTitle' => 'Brp Title',
            'brpBottomDesc' => 'Brp Bottom Desc',
        ];
    }
    
// public static function Brp($attribute, $ICNO) {
//        
//        if ($attribute  == 'jawatan'){
//            
//        $eval = Tblprcobiodata::find()->where(['ICNO' => $ICNO])->one()->jawatan->nama;}
//
//        elseif ($attribute == 'gred'){
//             $eval = Tblprcobiodata::find()->where(['ICNO' => $ICNO])->one()->jawatan->gred;
//        }
//        
//        elseif ($attribute == 'jabatan'){
//             $eval = Tblprcobiodata::find()->where(['ICNO' => $ICNO])->one()->department->fullname;
//        }
//        
//        elseif ($attribute == 'tarikhmula'){
//             $eval = Tblprcobiodata::find()->where(['ICNO' => $ICNO])->one()->tarikhmulalantik;
//        }
//        
//        elseif ($attribute == 'kontrak'){
//             $eval = \app\models\kontrak\Kontrak::find()->where(['icno' => $ICNO])->one()->tempoh_l_bsm;
//        }
//        
//        elseif ($attribute == 'pencen'){
//             $eval = \app\models\hronline\Tblrscopsnstatus::find()->where(['ICNO' => $ICNO])->one()->statusPencen->PsnStatusNm;
//        }
//        
//        elseif ($attribute == 'tarikhpencen'){
//             $model = \app\models\hronline\Tblrscoconfirmstatus::find()->where(['ICNO' => $ICNO])->max('ConfirmStatusStDt'); 
//             $eval = \app\models\hronline\Tblrscoconfirmstatus::find()->where(['ICNO' => $ICNO, 'ConfirmStatusStDt' => $model])->one()->tarikhMula;
//        }
//        
//        elseif ($attribute == 'tarikhpencen2'){
//             $eval = \app\models\hronline\Tblrscopsnstatus::find()->where(['ICNO' => $ICNO])->andWhere(['PsnStatusCd' => [1]])->one()->tarikhMula;
//        }
//        
//        elseif ($attribute == 'tahunpnp'){
//             $eval = \app\models\pengesahan\TblPnp::find()->where(['ICNO' => $ICNO])->one()->tahunPnp;
//        }
//        
//        elseif ($attribute == 'tarikhpnp'){
//             $eval = \app\models\pengesahan\TblPnp::find()->where(['ICNO' => $ICNO])->one()->tarikhpnp;
//        }
//        
//        elseif ($attribute == 'tarikhptm'){
//             $eval = \app\models\pengesahan\TblPtm::find()->where(['ICNO' => $ICNO])->one()->tarikhptm;
//        }
//        
//        elseif ($attribute == 'tarikhelaun'){
//             $eval = \app\models\Kemudahan\Borang::find()->where(['icno' => $ICNO])->one()->entrydate;
//        }
//        
//         elseif ($attribute == 'tarikhwilayah'){
//             $eval = \app\models\kemudahan\Borangwilayah::find()->where(['icno' => $ICNO])->one()->entrydate;
//        }
//        
//            elseif ($attribute == 'nama'){
//             $eval = Tblprcobiodata::find()->where(['ICNO' => $ICNO])->one()->CONm;
//        }
//        
//            elseif ($attribute == 'ic'){
//             $eval = Tblprcobiodata::find()->where(['ICNO' => $ICNO])->one()->ICNO;
//        }
//        
//        else {
//            $eval='__________';
//        }
//                                    
//        return $eval;
//    }
    
}

