<?php

namespace app\models\elnpt\elnpt2;

use Yii;

/**
 * This is the model class for table "dbo.Ext_SMBU09_VWPenilaianKursusPK07".
 *
 * @property string $KodKursus
 * @property string $NamaKursus
 * @property string $KodSesi
 * @property string $KategoriPelajar
 * @property int $Seksyen
 * @property double $FinalMean
 * @property string $NoIC
 * @property double $LNPT_Mean
 */
class PenilaianKursusPK07 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.Ext_SMBU09_VWPenilaianKursusPK07';
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
            [['Seksyen'], 'integer'],
            [['FinalMean', 'NoIC'], 'required'],
            [['FinalMean', 'LNPT_Mean'], 'number'],
            [['KodKursus', 'KodSesi', 'NoIC'], 'string', 'max' => 20],
            [['NamaKursus'], 'string', 'max' => 200],
            [['KategoriPelajar'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'KodKursus' => 'Kod Kursus',
            'NamaKursus' => 'Nama Kursus',
            'KodSesi' => 'Kod Sesi',
            'KategoriPelajar' => 'Kategori Pelajar',
            'Seksyen' => 'Seksyen',
            'FinalMean' => 'Final Mean',
            'NoIC' => 'No Ic',
            'LNPT_Mean' => 'Lnpt Mean',
        ];
    }
}
