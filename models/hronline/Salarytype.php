<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.salarytype".
 *
 * @property string $SalTypeCd
 * @property string $SalTypeNm
 */
class Salarytype extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.salarytype';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['SalTypeCd'], 'required'],
            [['SalTypeCd'], 'string', 'max' => 2],
            [['SalTypeNm'], 'string', 'max' => 255],
            [['SalTypeCd'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'SalTypeCd' => 'Sal Type Cd',
            'SalTypeNm' => 'Sal Type Nm',
        ];
    }
}
