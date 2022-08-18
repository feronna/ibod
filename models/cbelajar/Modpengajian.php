<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.modpengajian".
 *
 * @property int $id
 * @property int $modeID
 * @property string $studyMode
 */
class Modpengajian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_modpengajian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['modeID', 'studyMode'], 'required'],
            [['modeID'], 'integer'],
            [['studyMode'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'modeID' => 'Mode ID',
            'studyMode' => 'Study Mode',
        ];
    }
}
