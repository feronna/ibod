<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.salarypoint".
 *
 * @property string $SalPointCd
 * @property string $SalGrdId
 * @property string $SalGrdStatusCd
 * @property string $SalPointAmt
 * @property string $SalPointPeringkat
 * @property string $SalPointTingkat
 * @property string $SalPointId
 */
class Salarypoint extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.salarypoint';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['SalPointCd', 'SalGrdId', 'SalGrdStatusCd', 'SalPointAmt', 'SalPointPeringkat', 'SalPointTingkat', 'SalPointId'], 'string', 'max' => 510],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'SalPointCd' => 'Sal Point Cd',
            'SalGrdId' => 'Sal Grd ID',
            'SalGrdStatusCd' => 'Sal Grd Status Cd',
            'SalPointAmt' => 'Sal Point Amt',
            'SalPointPeringkat' => 'Sal Point Peringkat',
            'SalPointTingkat' => 'Sal Point Tingkat',
            'SalPointId' => 'Sal Point ID',
        ];
    }
}
