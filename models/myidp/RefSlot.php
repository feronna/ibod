<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "{{%myidp.ref_slot}}".
 *
 * @property int $slot
 * @property string $starttime
 * @property string $endtime
 */
class RefSlot extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%myidp.ref_slot}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slot'], 'required'],
            [['slot'], 'integer'],
            [['starttime', 'endtime'], 'safe'],
            [['slot'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'slot' => Yii::t('app', 'Slot'),
            'starttime' => Yii::t('app', 'Starttime'),
            'endtime' => Yii::t('app', 'Endtime'),
        ];
    }
}
