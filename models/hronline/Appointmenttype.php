<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.appointmenttype".
 *
 * @property string $ApmtTypeCd
 * @property string $ApmtTypeNm
 */
class Appointmenttype extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.appointmenttype';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ApmtTypeCd'], 'required'],
            [['ApmtTypeCd'], 'string', 'max' => 2],
            [['ApmtTypeNm'], 'string', 'max' => 255],
            [['ApmtTypeCd'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ApmtTypeCd' => 'Apmt Type Cd',
            'ApmtTypeNm' => 'Apmt Type Nm',
        ];
    }
}
