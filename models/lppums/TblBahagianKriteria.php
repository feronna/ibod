<?php

namespace app\models\lppums;

use Yii;

use app\models\lppums\RefKriteria;

/**
 * This is the model class for table "hrm.lppums_tbl_bahagian_has_kriteria".
 *
 * @property int $bhk_id
 * @property int $bahagian_id
 * @property int $kriteria_id
 * @property int $kump_khidmat
 */
class TblBahagianKriteria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_bahagian_has_kriteria';
    }
    
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bahagian_id', 'kriteria_id'], 'required'],
            [['bahagian_id', 'kriteria_id', 'kump_khidmat'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'bhk_id' => Yii::t('app', 'Bhk ID'),
            'bahagian_id' => Yii::t('app', 'Bahagian ID'),
            'kriteria_id' => Yii::t('app', 'Kriteria ID'),
            'kump_khidmat' => Yii::t('app', 'Kump Khidmat'),
        ];
    }
    
    public function getKriteria() {
        return $this->hasOne(RefKriteria::className(), ['kriteria_id' => 'kriteria_id']);
    }
    
}
