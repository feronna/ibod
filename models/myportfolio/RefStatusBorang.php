<?php

namespace app\models\myportfolio;

use Yii;

/**
 * This is the model class for table "hrm.myjd_ref_status_borang".
 *
 * @property int $id
 * @property string $nama
 */
class RefStatusBorang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.myjd_ref_status_borang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
        ];
    }
}
