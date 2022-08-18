<?php

namespace app\models\harta;

use Yii;

/**
 * This is the model class for table "harta.tbl_senarai".
 *
 * @property int $senarai_id
 * @property string $keterangan
 * @property string $hartaCd
 */
class TblSenarai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.harta_tbl_senarai';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['keterangan'], 'string', 'max' => 50],
            [['hartaCd'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'senarai_id' => 'Senarai ID',
            'keterangan' => 'Keterangan',
            'hartaCd' => 'Harta Cd',
        ];
    }
    
     public static function dropdown() {   
        static $dropdown;
        if($dropdown === null){
            $models = static::find()->all();
            foreach ($models as $model){
                $dropdown[$model->senarai_id] = $model->keterangan;
            }
        }
        return $dropdown;
    }
     public function getJenisHarta() {
        return $this->hasOne(TblJenisHarta::className(), ['hartaCd'=>'hartaCd']);
    }
}
