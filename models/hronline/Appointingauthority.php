<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.appointingauthority".
 *
 * @property string $AptAthyCd
 * @property string $AptAthyNm
 */
class Appointingauthority extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.appointingauthority';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['AptAthyCd'], 'required'],
            [['AptAthyCd'], 'string', 'max' => 5],
            [['AptAthyNm'], 'string', 'max' => 255],
            [['AptAthyCd'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'AptAthyCd' => 'Apt Athy Cd',
            'AptAthyNm' => 'Apt Athy Nm',
        ];
    }
}
