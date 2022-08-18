<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.confirmationstatus".
 *
 * @property int $ConfirmStatusCd
 * @property string $ConfirmStatusNm
 */
class Confirmationstatus extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.confirmationstatus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ConfirmStatusCd'], 'required'],
            [['ConfirmStatusCd'], 'integer'],
            [['ConfirmStatusNm'], 'string', 'max' => 255],
            [['ConfirmStatusCd'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ConfirmStatusCd' => 'Confirm Status Cd',
            'ConfirmStatusNm' => 'Confirm Status Nm',
        ];
    }
}
