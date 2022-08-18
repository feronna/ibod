<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.servicetype".
 *
 * @property string $ServTypeCd
 * @property string $ServTypeNm
 * @property string $ServTypeCurrInd
 */
class Servicetype extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.servicetype';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ServTypeCd'], 'required'],
            [['ServTypeCd'], 'string', 'max' => 3],
            [['ServTypeNm'], 'string', 'max' => 100],
            [['ServTypeCurrInd'], 'string', 'max' => 1],
            [['ServTypeCd'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ServTypeCd' => 'Serv Type Cd',
            'ServTypeNm' => 'Serv Type Nm',
            'ServTypeCurrInd' => 'Serv Type Curr Ind',
        ];
    }
}
