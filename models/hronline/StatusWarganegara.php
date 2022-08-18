<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.nationalitystatus".
 *
 * @property string $NatStatusCd
 * @property string $NatStatus
 * @property string $NatStatusMM
 */
class StatusWarganegara extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.nationalitystatus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['NatStatusCd'], 'required'],
            [['NatStatusCd'], 'string', 'max' => 1],
            [['NatStatus'], 'string', 'max' => 255],
            [['NatStatusMM'], 'string', 'max' => 10],
            [['NatStatusCd'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'NatStatusCd' => 'Nat Status Cd',
            'NatStatus' => 'Nat Status',
            'NatStatusMM' => 'Nat Status Mm',
        ];
    }
}
