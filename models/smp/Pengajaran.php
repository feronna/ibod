<?php

namespace app\models\smp;

use Yii;
use app\models\kontrak\TblPengajaran;

/**
 * This is the model class for table "dbo.Ext_HR01_Pengajaran".
 *
 * @property int $AutoId
 * @property string $NOKP
 * @property string $SMP07_KodMP
 * @property string $NAMAKURSUS
 * @property int $BILPELAJAR
 * @property int $SEKSYEN
 * @property string $SESI
 * @property int $JAMKREDIT
 * @property string $KATEGORIPELAJAR
 */
class Pengajaran extends \yii\db\ActiveRecord
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
            [['AutoId', 'BILPELAJAR', 'SEKSYEN', 'JAMKREDIT'], 'integer'],
            [['NOKP'], 'string', 'max' => 20],
            [['SMP07_KodMP'], 'string', 'max' => 10],
            [['NAMAKURSUS'], 'string', 'max' => 200],
            [['SESI'], 'string', 'max' => 11],
            [['KATEGORIPELAJAR'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'AutoId' => 'Auto ID',
            'NOKP' => 'Nokp',
            'SMP07_KodMP' => 'Smp07 Kod Mp',
            'NAMAKURSUS' => 'Namakursus',
            'BILPELAJAR' => 'Bilpelajar',
            'SEKSYEN' => 'Seksyen',
            'SESI' => 'Sesi',
            'JAMKREDIT' => 'Jamkredit',
            'KATEGORIPELAJAR' => 'Kategoripelajar',
        ];
    }
    
    public function getCoteaching() {
        return $this->hasOne(TblPengajaran::className(), ['id' => 'AutoId']);
    }
    
    
     public function getJamwaktu() {
        return $this->hasOne(\app\models\elnpt\TblJamWaktu::className(), ['ref_id' => 'AutoId']);
    }
}
