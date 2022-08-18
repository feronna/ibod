<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.armypolice".
 *
 * @property int $ArmyPoliceCd
 * @property string $ArmyPolice
 * @property string $idmm
 */
class StatusUniform extends \yii\db\ActiveRecord
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
        return 'hronline.armypolice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ArmyPoliceCd'], 'required'],
            [['ArmyPoliceCd'], 'integer'],
            [['ArmyPolice'], 'string', 'max' => 255],
            [['idmm'], 'string', 'max' => 10],
            [['ArmyPoliceCd'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ArmyPoliceCd' => 'Army Police Cd',
            'ArmyPolice' => 'Army Police',
            'idmm' => 'Idmm',
        ];
    }
}
