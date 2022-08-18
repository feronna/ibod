<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.sponsorship".
 *
 * @property string $SponsorshipCd
 * @property string $SponsorshipNm
 */
class Penaja extends \yii\db\ActiveRecord
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
        return 'hronline.sponsorship';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['SponsorshipCd'], 'required'],
            [['SponsorshipCd'], 'string', 'max' => 4],
            [['SponsorshipNm'], 'string', 'max' => 150],
            [['SponsorshipCd'], 'unique'],
            [['isActive'],'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'SponsorshipCd' => 'Sponsorship Cd',
            'SponsorshipNm' => 'Sponsorship Nm',
        ];
    }
    
    public function getStatus() {
        return $this->isActive ? "Aktif":"Tidak aktif";
    }
}
