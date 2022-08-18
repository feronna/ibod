<?php

namespace app\models\elnpt\simulation;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_sim_ref_aktiviti".
 *
 * @property int $id
 * @property int $kategori
 * @property int $order_no
 * @property string $aktiviti
 * @property int $nilai_mata_id
 * @property int $isHakiki
 * @property string $unit
 */
class RefAktiviti extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_sim_ref_aktiviti';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kategori', 'order_no', 'nilai_mata_id', 'isHakiki'], 'integer'],
            [['aktiviti', 'unit'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kategori' => 'Kategori',
            'order_no' => 'Order No',
            'aktiviti' => 'Aktiviti',
            'nilai_mata_id' => 'Nilai Mata ID',
            'isHakiki' => 'Is Hakiki',
            'unit' => 'Unit',
        ];
    }
}
