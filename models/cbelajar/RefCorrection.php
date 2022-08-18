<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.ref_correction".
 *
 * @property int $id
 * @property string $correction
 */
class RefCorrection extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_ref_correction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['correction'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'correction' => 'Correction',
        ];
    }
}
