<?php

namespace app\models\elnpt\elnpt2;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_v2_ref_skor_f2f".
 *
 * @property int $id
 * @property int $min_pelajar
 * @property double $syarahan
 * @property double $tutorial
 * @property double $amali
 */
class RefSkorF2f extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_v2_ref_skor_f2f';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['min_pelajar'], 'integer'],
            [['syarahan', 'tutorial', 'amali'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'min_pelajar' => 'Min Pelajar',
            'syarahan' => 'Syarahan',
            'tutorial' => 'Tutorial',
            'amali' => 'Amali',
        ];
    }
}
