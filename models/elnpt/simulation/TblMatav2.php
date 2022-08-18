<?php

namespace app\models\elnpt\simulation;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_tbl_mata_2022_copy".
 *
 * @property int $id
 * @property int $kategori_id
 * @property int $aktiviti_id
 * @property int $komponen_id
 * @property int $nilai_mata_id
 * @property double $nilai_mata
 */
class TblMatav2 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_tbl_mata_2022_copy';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kategori_id', 'aktiviti_id', 'komponen_id', 'nilai_mata_id'], 'integer'],
            [['nilai_mata'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kategori_id' => 'Kategori ID',
            'aktiviti_id' => 'Aktiviti ID',
            'komponen_id' => 'Komponen ID',
            'nilai_mata_id' => 'Nilai Mata ID',
            'nilai_mata' => 'Nilai Mata',
        ];
    }
}
