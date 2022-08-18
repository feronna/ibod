<?php

namespace app\models\mohonjawatan;
use app\models\mohonjawatan\RefItka;
use app\models\mohonjawatan\RefItp;
use app\models\mohonjawatan\RefBiw;
use app\models\mohonjawatan\TblPermohonan;
use Yii;

/**
 * This is the model class for table "mohonjawatan.tbl_penetapan_gaji".
 *
 * @property int $id
 * @property string $fname
 * @property double $min
 * @property double $max
 * @property int $itka_id
 * @property int $itp_id
 * @property int $biw_id
 */
class TblPenetapanGaji extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.mj_tbl_penetapan_gaji';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['min', 'max'], 'number'],
            [['itka_id', 'itp_id', 'biw_id'], 'integer'],
            [['fname'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fname' => 'Fname',
            'min' => 'Min',
            'max' => 'Max',
            'itka_id' => 'Itka ID',
            'itp_id' => 'Itp ID',
            'biw_id' => 'Biw ID',
        ];
    }
    public function getItka(){
      return $this->hasOne(RefItka::className(), ['id' => 'itka_id']);
    }
       public function getItp(){
      return $this->hasOne(RefItp::className(), ['id' => 'itp_id']);
    }
       public function getBiw(){
      return $this->hasOne(RefBiw::className(), ['id' => 'biw_id']);
    }
    
    public static function implikasi($id){
        $value = 0;
        $model = TblPenetapanGaji::findOne(['id'=>$id]);
        if($model){
            $value = (($model->min)*($model->biw->kadar))+($model->itka->jumlah)+($model->itp->jumlah)+($model->min);   
        }
        return $value;
    }
}
