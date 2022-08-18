<?php

namespace app\models\elnpt\elnpt2;

use Yii;

/**
 * This is the model class for table "dbo.Ext_SMBU09_VWPenilaianKursusPK07_FPSK".
 *
 * @property string $KodSubjek
 * @property string $NamaBI
 * @property string $SesiSem
 * @property string $KategoriPelajar
 * @property string $Seksyen
 * @property string $FinalMean
 * @property string $NoIC
 */
class PenilaianKursusPK07_FPSK extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.Ext_SMBU09_VWPenilaianKursusPK07_FPSK';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db14');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['KategoriPelajar', 'Seksyen'], 'required'],
            [['FinalMean'], 'number'],
            [['KodSubjek'], 'string', 'max' => 10],
            [['NamaBI'], 'string', 'max' => 100],
            [['SesiSem'], 'string', 'max' => 50],
            [['KategoriPelajar'], 'string', 'max' => 21],
            [['Seksyen'], 'string', 'max' => 1],
            [['NoIC'], 'string', 'max' => 14],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'KodSubjek' => 'Kod Subjek',
            'NamaBI' => 'Nama Bi',
            'SesiSem' => 'Sesi Sem',
            'KategoriPelajar' => 'Kategori Pelajar',
            'Seksyen' => 'Seksyen',
            'FinalMean' => 'Final Mean',
            'NoIC' => 'No Ic',
        ];
    }
}
