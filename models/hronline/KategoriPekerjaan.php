<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.occupationcategory".
 *
 * @property string $OccCatCd
 * @property string $OccCat
 * @property int $isActive
 */
class KategoriPekerjaan extends \yii\db\ActiveRecord
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
        return 'hronline.occupationcategory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['OccCat'], 'required'],
            [['isActive'], 'integer'],
            [['OccCat'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'OccCatCd' => 'Occ Cat Cd',
            'OccCat' => 'Occ Cat',
            'isActive' => 'Is Active',
        ];
    }
}
