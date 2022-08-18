<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "hrd.cb_refelaunk".
 *
 * @property string $id
 * @property string $elaun
 * @property string $bayaran
 * @property int $kadar_a
 * @property int $kadar_b
 */
class ElaunKadar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_refelaunk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kadar_a', 'kadar_b'], 'integer'],
            [['id', 'bayaran'], 'string', 'max' => 20],
            [['elaun'], 'string', 'max' => 255],
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
            'kadar_b' => 'Kadar B',
        ];
    }
}
