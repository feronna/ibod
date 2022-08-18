<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "dbo.Ext_HR01_Pengajaran".
 *
 * @property string $NOKP
 * @property string $SMP07_KodMP
 * @property string $NAMAKURSUS
 * @property int $BILPELAJAR
 * @property int $SEKSYEN
 * @property string $SESI
 * @property int $JAMKREDIT
 * @property string $KATEGORIPELAJAR
 */
class TblPengajaran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.Ext_HR01_Pengajaran';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db5');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['NOKP', 'SMP07_KodMP', 'NAMAKURSUS', 'SESI', 'KATEGORIPELAJAR'], 'string'],
            [['BILPELAJAR', 'SEKSYEN', 'JAMKREDIT'], 'integer'],
            [['AutoId','safe']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'NOKP' => 'ICNO',
            'SMP07_KodMP' => 'KOD',
            'NAMAKURSUS' => 'NAMA KURSUS',
            'BILPELAJAR' => 'BIL PELAJAR',
            'SEKSYEN' => 'SEKSYEN',
            'SESI' => 'SESI',
            'JAMKREDIT' => 'JAMKREDIT',
            'KATEGORIPELAJAR' => 'KATEGORI',
        ];
    }
    
    public function getKategori() {
        return $this->hasOne(\app\models\cv\RefPengajaran::className(), ['kategori' => 'KATEGORIPELAJAR']);
    }
}
