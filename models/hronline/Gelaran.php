<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.title".
 *
 * @property string $TitleCd
 * @property string $Title
 * @property string $CfdTitleStatus
 * @property string $MMTitleCd
 * @property string $TitleFullname
 */
class Gelaran extends \yii\db\ActiveRecord
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
        return 'hronline.title';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['TitleCd','Title', 'TitleFullname'], 'required','message'=>'Ruang ini adalah mandatori'],
            [['TitleCd', 'MMTitleCd'], 'string', 'max' => 4],
            [['Title', 'TitleFullname'], 'string', 'max' => 255],
            [['CfdTitleStatus'], 'string', 'max' => 1],
            [['TitleCd'], 'unique'],
            [['isActive'],'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'TitleCd' => 'Title Cd',
            'Title' => 'Title',
            'CfdTitleStatus' => 'Cfd Title Status',
            'MMTitleCd' => 'Mmtitle Cd',
            'TitleFullname' => 'Title Fullname',
        ];
    }
    
    public function getStatus() {
        return $this->isActive ? "Aktif":"Tidak aktif";
    }
}
