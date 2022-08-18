<?php

namespace app\models\ln;

use Yii;

/**
 * This is the model class for table "ln.ref_perbelanjaan".
 *
 * @property int $id
 * @property string $perbelanjaan
 */
class Refperbelanjaan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
//        return 'ln.ref_perbelanjaan';
        return 'hrm.ln_ref_perbelanjaan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['perbelanjaan'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'perbelanjaan' => 'Perbelanjaan',
        ];
    }
}
