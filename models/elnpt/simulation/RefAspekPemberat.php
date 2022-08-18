<?php

namespace app\models\elnpt\simulation;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_v3_ref_aspek_pemberat".
 *
 * @property int $id
 * @property int $bahagian
 * @property int $aspek_id
 * @property double $pemberat
 */
class RefAspekPemberat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_v3_ref_aspek_pemberat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bahagian', 'aspek_id'], 'integer'],
            [['pemberat'], 'number'],
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
            'pemberat' => 'Pemberat',
        ];
    }
}
