<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "hrd.cb_refelaun".
 *
 * @property string $id
 * @property string $elaun
 * @property string $bayaran KPT/UMS; UMS; KPT
 * @property int $kadar_a
 * @property int $kadar_b
 * @property string $status Bujang ; Berkahwin
 */
class ElaunKadarB extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_refelaun';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kadar_a', 'kadar_b'], 'integer'],
            [['id', 'bayaran', 'status'], 'string', 'max' => 20],
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
            'status' => 'Status',
        ];
    }
}
