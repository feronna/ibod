<?php

namespace app\models\elnpt\elnpt2;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_v2_ref_aspek_skor".
 *
 * @property int $id
 * @property int $bahagian
 * @property int $aspek_id
 * @property string $desc
 * @property double $skor
 */
class RefAspekSkor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_v2_ref_aspek_skor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bahagian', 'aspek_id'], 'integer'],
            [['skor'], 'number'],
            [['desc'], 'string', 'max' => 100],
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
            'desc' => 'Desc',
            'skor' => 'Skor',
        ];
    }
}
