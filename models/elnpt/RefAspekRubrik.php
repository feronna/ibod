<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_ref_aspek_rubrik".
 *
 * @property int $id
 * @property int $aspek_id
 * @property string $penilaian
 * @property double $threshold
 * @property double $skor
 */
class RefAspekRubrik extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_ref_aspek_rubrik';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['aspek_id'], 'integer'],
            [['threshold', 'skor'], 'number'],
            [['penilaian'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'aspek_id' => 'Aspek ID',
            'penilaian' => 'Penilaian',
            'threshold' => 'Threshold',
            'skor' => 'Skor',
        ];
    }
}
