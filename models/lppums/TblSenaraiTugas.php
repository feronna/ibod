<?php

namespace app\models\lppums;

use Yii;

use app\models\lppums\TblMain;

/**
 * This is the model class for table "hrm.lppums_tbl_senarai_tugas".
 *
 * @property string $senarai_tugas_id
 * @property string $lpp_id
 * @property string $senarai_tugas
 */
class TblSenaraiTugas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_senarai_tugas';
    }
    
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
//    public static function getDb()
//    {
//        return Yii::$app->get('db');
//    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_id'], 'integer'],
            [['senarai_tugas'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'senarai_tugas_id' => 'Senarai Tugas ID',
            'lpp_id' => 'Lpp ID',
            'senarai_tugas' => 'Senarai Tugas',
        ];
    }
    
    public function getLpp() {
        return $this->hasOne(TblMain::className(), ['lpp_id' => 'lpp_id']);
    }
}
