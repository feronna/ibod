<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.pensionauthority".
 *
 * @property string $PsnAthyCd
 * @property string $PsnAthyNm
 */
class Pensionauthority extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.pensionauthority';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['PsnAthyCd'], 'required'],
            [['PsnAthyCd'], 'string', 'max' => 30],
            [['PsnAthyNm'], 'string', 'max' => 255],
            [['PsnAthyCd'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'PsnAthyCd' => 'Psn Athy Cd',
            'PsnAthyNm' => 'Psn Athy Nm',
        ];
    }
}
