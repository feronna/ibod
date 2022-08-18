<?php

namespace app\models\myportfolio;

use Yii;

/**
 * This is the model class for table "myportfolio.ref_kehadiran".
 *
 * @property int $id
 * @property string $tahap_kehadiran
 */
class RefKehadiran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.myjd_ref_kehadiran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahap_kehadiran'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tahap_kehadiran' => 'Tahap Kehadiran',
        ];
    }
}
