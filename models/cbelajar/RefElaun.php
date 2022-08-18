<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "hrd.cb_ref_elaun".
 *
 * @property int $id
 * @property string $kod
 * @property string $elaun
 */
class RefElaun extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_ref_elaun';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kod'], 'string', 'max' => 10],
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
            'kod' => 'Kod',
            'elaun' => 'Elaun',
        ];
    }
}
