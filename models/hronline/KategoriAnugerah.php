<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.awardcategory".
 *
 * @property string $AwdCatCd
 * @property string $AwdCat
 */
class KategoriAnugerah extends \yii\db\ActiveRecord
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
        return 'hronline.awardcategory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['AwdCatCd','AwdCat'], 'required','message'=>'Ruang ini adalah mandatori'],
            [['AwdCatCd'], 'string', 'max' => 2],
            [['AwdCat'], 'string', 'max' => 255],
            [['AwdCatCd'], 'unique'],
            [['isActive'],'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'AwdCatCd' => 'Awd Cat Cd',
            'AwdCat' => 'Awd Cat',
        ];
    }
    
    public function getStatus() {
        return $this->isActive ? "Aktif":"Tidak aktif";
    }
}
