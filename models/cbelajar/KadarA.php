<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "hrd.cb_refelauna".
 *
 * @property string $id
 * @property string $elaun
 * @property string $bayaran
 * @property string $kadar_a
 * @property string $jenis_kadar
 */
class KadarA extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_refelauna';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'string', 'max' => 20],
            [['elaun'], 'string', 'max' => 255],
            [['bayaran', 'kadar_a'], 'string', 'max' => 50],
            [['jenis_kadar'], 'string', 'max' => 2],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'elaun' => 'Elaun',
            'bayaran' => 'Bayaran',
            'kadar_a' => 'Kadar A',
            'jenis_kadar' => 'Jenis Kadar',
        ];
    }
}
