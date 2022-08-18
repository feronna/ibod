<?php

namespace app\models\elnpt\elnpt2;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_v2_ref_aspek_peratus".
 *
 * @property int $id
 * @property int $bahagian
 * @property int $aspek_id
 * @property double $min_skor
 * @property double $peratus
 * @property string $julat_skor
 */
class RefAspekPeratus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_v2_ref_aspek_peratus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bahagian', 'aspek_id'], 'integer'],
            [['min_skor', 'peratus'], 'number'],
            [['julat_skor'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bahagian' => 'Bahagian',
            'aspek_id' => 'Aspek ID',
            'min_skor' => 'Min Skor',
            'peratus' => 'Peratus',
            'julat_skor' => 'Julat Skor',
        ];
    }
}
