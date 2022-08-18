<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.maritalstatus".
 *
 * @property string $MrtlStatusCd
 * @property string $MrtlStatus
 * @property string $MrtlStatusCdMM
 */
class TarafPerkahwinan extends \yii\db\ActiveRecord
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
        return 'hronline.maritalstatus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['MrtlStatusCd'], 'required'],
            [['MrtlStatusCd'], 'string', 'max' => 1],
            [['MrtlStatus'], 'string', 'max' => 255],
            [['MrtlStatusCdMM'], 'string', 'max' => 20],
            [['MrtlStatusCd'], 'unique'],
            [['hrmiscd'], 'string'],
            [['isActive'],'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'MrtlStatusCd' => 'Mrtl Status Cd',
            'MrtlStatus' => 'Mrtl Status',
            'MrtlStatusCdMM' => 'Mrtl Status Cd Mm',
        ];
    }

    public function getStatus() {
        return $this->isActive ? "Aktif" : "Tidak Aktif";
    }
}
