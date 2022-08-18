<?php

namespace app\models\ln;

use Yii;

/**
 * This is the model class for table "hrm.ln_ref_penyelarasan".
 *
 * @property int $id
 * @property string $penyelarasan
 */
class Refpenyelarasan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.ln_ref_penyelarasan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penyelarasan'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'penyelarasan' => 'Penyelarasan',
        ];
    }
}
