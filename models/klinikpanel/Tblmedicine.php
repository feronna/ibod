<?php

namespace app\models\klinikpanel;
use app\models\klinikpanel\RefMedicine;;

use Yii;

/**
 * This is the model class for table "klinikpanel2.tblmedicine".
 *
 * @property int $id
 * @property int $med_visit_id
 * @property int $tbl_med_id
 * @property double $tblmed_price
 * @property int $tblmed_unit
 */
class Tblmedicine extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.myhealth_tblmedicine';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['med_visit_id', 'tbl_med_id', 'tblmed_unit'], 'integer'],
            [['tblmed_price'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'med_visit_id' => 'Med Visit ID',
            'tbl_med_id' => 'Tbl Med ID',
            'tblmed_price' => 'Tblmed Price',
            'tblmed_unit' => 'Tblmed Unit',
        ];
    }
    
        public function getNamaUbat()
    {
        return $this->hasOne(Refprescription::className(), ['id' => 'tbl_med_id']);
    }
    
}
