<?php

namespace app\models\lnpk;

use Yii;

/**
 * This is the model class for table "hrm.lnpk_ref_kriteria".
 *
 * @property int $kriteria_id
 * @property int $array_id
 * @property string $kriteria_label
 * @property string $kriteria_desc
 * @property int $kriteria_order
 */
class RefKriteria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lnpk_ref_kriteria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['array_id', 'kriteria_order'], 'integer'],
            [['kriteria_desc'], 'string'],
            [['kriteria_label'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kriteria_id' => 'Kriteria ID',
            'array_id' => 'Array ID',
            'kriteria_label' => 'Kriteria Label',
            'kriteria_desc' => 'Kriteria Desc',
            'kriteria_order' => 'Kriteria Order',
        ];
    }
}
