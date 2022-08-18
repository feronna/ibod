<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "hrd.cb_refelaunb".
 *
 * @property string $id
 * @property string $elaun
 * @property string $bayaran
 * @property string $kadar_b
 * @property string $jenis_kadar
 */
class KadarB extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_refelaunb';
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
            [['bayaran', 'kadar_b'], 'string', 'max' => 50],
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
            'kadar_b' => 'Kadar B',
            'jenis_kadar' => 'Jenis Kadar',
        ];
    }
}
