<?php

namespace app\models\gaji;

use Yii;

/**
 * This is the model class for table "hrm.gaji_tbl_kump_lpg".
 *
 * @property int $id
 * @property int $kump_id rel tbl_kumpulan(id)
 * @property string $RR_REASON_CODE rel gaji_lpg(lpgCd)
 */
class TblKumpLpg extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.gaji_tbl_kump_lpg';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kump_id'], 'integer'],
            [['RR_REASON_CODE'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kump_id' => 'Kump ID',
            'RR_REASON_CODE' => 'Sebab Perubahan / Kew8 / LPG',
            'lpgName' => 'Sebab Perubahan / Kew8 / LPG',
        ];
    }

    public function getLpg()
    {
        return $this->hasOne(RefRocReason::className(), ['RR_REASON_CODE' => 'RR_REASON_CODE']);
    }

    public function getLpgName()
    {
        return $this->lpg->RR_REASON_DESC;
    }

    public static function lpgList($kump_id){

        $model = self::find()->select('RR_REASON_CODE')->where(['kump_id'=>$kump_id])->asArray()->all();

        $reason = RefRocReason::find()->where(['RR_CMPY_CODE'=> 'UMS'])->andFilterWhere(['not', ['RR_REASON_CODE'=>$model]])->all();

        return $reason;
    }

    public static function LpgId($icno){
        $kumps = TblKumpStaf::find()->where(['icno'=>$icno])->one();
        $lpd_ids = [];
        if(!empty($kumps)){
            
            $lpg_ids_array = self::find()->select('RR_REASON_CODE')->where(['kump_id'=>$kumps->kump_id])->asArray()->all();
            if(!empty($lpg_ids_array)){
                for ( $i = 0; $i < count($lpg_ids_array); $i++) {
                    array_push($lpd_ids, $lpg_ids_array[$i]['RR_REASON_CODE']);
                }             
            }
        }
        return $lpd_ids; //array of lpg id that allowed for the user;
    }
}
