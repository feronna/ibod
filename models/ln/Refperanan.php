<?php

namespace app\models\ln;

use Yii;

/**
 * This is the model class for table "ln.ref_peranan".
 *
 * @property int $id
 * @property string $peranan
 */
class Refperanan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
//        return 'ln.ref_peranan';
        return 'hrm.ln_ref_peranan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['peranan'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'peranan' => 'Peranan',
        ];
    }
}
