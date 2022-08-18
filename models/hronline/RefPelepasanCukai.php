<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.ref_pelepasan_cukai".
 *
 * @property int $id
 * @property string $soalanID
 * @property string $jenis_pelepasan
 * @property string $soalan
 * @property string $jumlah
 */
class RefPelepasanCukai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.ref_pelepasan_cukai';
    }
    
      public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['soalan'], 'string'],
            [['jumlah'], 'number'],
            [['soalanID'], 'string', 'max' => 5],
            [['jenis_pelepasan'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'soalanID' => Yii::t('app', 'Soalan ID'),
            'jenis_pelepasan' => Yii::t('app', 'Jenis Pelepasan'),
            'soalan' => Yii::t('app', 'Soalan'),
            'jumlah' => Yii::t('app', 'Jumlah'),
        ];
    }
}
