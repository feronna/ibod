<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "dbo.Ext_SMBU01_PA_VWMaklumatKursus".
 *
 * @property string $KodSubjek
 * @property string $NamaSubjekBM
 * @property string $NamaSubjekBI
 * @property int $JamKredit
 * @property string $Fakulti
 * @property int $Status
 * @property string $KodKategoriPelajar
 * @property string $NamaKategoriPelajar
 */
class RefPnpKursus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.Ext_SMBU01_PA_VWMaklumatKursus';
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
            [['KodSubjek'], 'required'],
            [['JamKredit', 'Status'], 'integer'],
            [['KodSubjek'], 'string', 'max' => 9],
            [['NamaSubjekBM', 'NamaSubjekBI'], 'string', 'max' => 200],
            [['Fakulti'], 'string', 'max' => 5],
            [['KodKategoriPelajar'], 'string', 'max' => 3],
            [['NamaKategoriPelajar'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'KodSubjek' => 'Kod Subjek',
            'NamaSubjekBM' => 'Nama Subjek Bm',
            'NamaSubjekBI' => 'Nama Subjek Bi',
            'JamKredit' => 'Jam Kredit',
            'Fakulti' => 'Fakulti',
            'Status' => 'Status',
            'KodKategoriPelajar' => 'Kod Kategori Pelajar',
            'NamaKategoriPelajar' => 'Nama Kategori Pelajar',
        ];
    }
}
