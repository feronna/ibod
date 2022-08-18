<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.conferredby".
 *
 * @property string $CfdByCd
 * @property string $CfdBy
 */
class DianugerahkanOleh extends \yii\db\ActiveRecord
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
        return 'hronline.conferredby';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CfdByCd','CfdBy'], 'required','message'=>'Ruang ini adalah mandatori'],
            [['CfdByCd'], 'string', 'max' => 4],
            [['CfdBy'], 'string', 'max' => 255],
            [['CfdByCd'], 'unique'],
            [['isActive'],'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CfdByCd' => 'Cfd By Cd',
            'CfdBy' => 'Cfd By',
        ];
    }
    
    public function getStatus() {
        return $this->isActive ? "Aktif":"Tidak aktif";
    }
}
