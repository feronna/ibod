<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.tbl_pelepasan_cukai".
 *
 * @property int $id
 * @property string $icno
 * @property string $umsper
 * @property string $jenis_pelepasan
 * @property int $a1
 * @property int $a2
 * @property int $a3
 * @property int $a4
 * @property int $a5
 * @property int $a6
 * @property int $a7
 * @property int $a8
 * @property int $a9
 * @property int $a10
 * @property int $a11
 * @property int $a12
 * @property int $a13
 * @property int $a14
 * @property int $a15
 * @property int $a16
 * @property int $a17
 * @property int $a18
 * @property int $a19
 * @property int $a20
 * @property int $a21
 * @property int $a22
 * @property int $a23
 * @property int $a24
 * @property string $created_at
 */
class TblPelepasanCukai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.tbl_pelepasan_cukai';
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
            [['a1', 'a2', 'a3', 'a4', 'a5', 'a6', 'a7', 'a8', 'a9', 'a10', 'a11', 'a12', 'a13', 'a14', 'a15', 'a16', 'a17', 'a18', 'a19', 'a20', 'a21', 'a22', 'a23', 'a24'], 'integer'],
            [['created_at', 'status'], 'safe'],
            [['icno', 'umsper'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'icno' => Yii::t('app', 'Icno'),
            'umsper' => Yii::t('app', 'Umsper'),
            'jenis_pelepasan' => Yii::t('app', 'Jenis Pelepasan'),
            'a1' => Yii::t('app', 'A1'),
            'a2' => Yii::t('app', 'A2'),
            'a3' => Yii::t('app', 'A3'),
            'a4' => Yii::t('app', 'A4'),
            'a5' => Yii::t('app', 'A5'),
            'a6' => Yii::t('app', 'A6'),
            'a7' => Yii::t('app', 'A7'),
            'a8' => Yii::t('app', 'A8'),
            'a9' => Yii::t('app', 'A9'),
            'a10' => Yii::t('app', 'A10'),
            'a11' => Yii::t('app', 'A11'),
            'a12' => Yii::t('app', 'A12'),
            'a13' => Yii::t('app', 'A13'),
            'a14' => Yii::t('app', 'A14'),
            'a15' => Yii::t('app', 'A15'),
            'a16' => Yii::t('app', 'A16'),
            'a17' => Yii::t('app', 'A17'),
            'a18' => Yii::t('app', 'A18'),
            'a19' => Yii::t('app', 'A19'),
            'a20' => Yii::t('app', 'A20'),
            'a21' => Yii::t('app', 'A21'),
            'a22' => Yii::t('app', 'A22'),
            'a23' => Yii::t('app', 'A23'),
            'a24' => Yii::t('app', 'A24'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }
}
