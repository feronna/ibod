<?php

namespace app\models\myportfolio;

use Yii;

/**
 * This is the model class for table "myportfolio.ref_lnpt".
 *
 * @property int $id
 * @property string $tahap_lnpt
 */
class RefLnpt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.myjd_ref_lnpt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahap_lnpt'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tahap_lnpt' => 'Tahap Lnpt',
        ];
    }
}
