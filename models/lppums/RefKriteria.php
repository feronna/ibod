<?php

namespace app\models\lppums;

use Yii;

/**
 * This is the model class for table "hrm.lppums_ref_kriteria".
 *
 * @property int $kriteria_id
 * @property string $kriteria_label 	
 * @property string $kriteria
 */
class RefKriteria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_kriteria';
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
            [['kriteria_label'], 'string', 'max' => 100],
            [['kriteria'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kriteria_id' => Yii::t('app', 'Kriteria ID'),
            'kriteria_label' => Yii::t('app', 'Kriteria'),
            'kriteria' => Yii::t('app', 'Penerangan kriteria'),
        ];
    }

    public function getFullLabel()
    {
        return ucwords(strtolower($this->kriteria_label)) . ' - ' . $this->kriteria;
    }

    public static function retLabel($id, $type)
    {

        if ($type == 1) {
            return self::findOne(['kriteria_id' => $id])->kriteria_label;
        }

        if($type == 2) {
            return self::findOne(['kriteria_id' => $id])->kriteria;
        }
    }
}
