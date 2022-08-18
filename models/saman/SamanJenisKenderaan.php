<?php

namespace app\models\saman;

use Yii;

/**
 * This is the model class for table "ekeselamatan.r_08_eks_jenis_kenderaant".
 *
 * @property string $KODJENIS
 * @property string $Keterangan
 */
class SamanJenisKenderaan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    public static function tableName()
    {
        return 'ekeselamatan.r_08_eks_jenis_kenderaant';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['KODJENIS'], 'required'],
            [['KODJENIS'], 'string', 'max' => 3],
            [['Keterangan'], 'string', 'max' => 40],
            [['KODJENIS'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'KODJENIS' => 'Kodjenis',
            'Keterangan' => 'Keterangan',
        ];
    }
}
