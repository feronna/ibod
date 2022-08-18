<?php

namespace app\models\elnpt\inovasi;

use Yii;

/**
 * This is the model class for table "dbo.vw_LNPT_PertandinganPereka".
 *
 * @property string $KodPereka
 * @property string $Nama
 * @property string $NoIC
 * @property string $Peranan
 * @property string $Tahap
 * @property string $Tahun
 * @property int $BilPenerimaImpak
 * @property string $AmaunProjek
 * @property string $Pereka_kod
 */
class TblPertandinganPereka extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.vw_LNPT_PertandinganPereka';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db10');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['KodPereka'], 'string'],
            [['Peranan', 'Tahap'], 'required'],
            [['BilPenerimaImpak'], 'integer'],
            [['AmaunProjek'], 'number'],
            [['Nama'], 'string', 'max' => 500],
            [['NoIC', 'Pereka_kod'], 'string', 'max' => 50],
            [['Peranan'], 'string', 'max' => 5],
            [['Tahap'], 'string', 'max' => 10],
            [['Tahun'], 'string', 'max' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'KodPereka' => 'Kod Pereka',
            'Nama' => 'Nama',
            'NoIC' => 'No Ic',
            'Peranan' => 'Peranan',
            'Tahap' => 'Tahap',
            'Tahun' => 'Tahun',
            'BilPenerimaImpak' => 'Bil Penerima Impak',
            'AmaunProjek' => 'Amaun Projek',
            'Pereka_kod' => 'Pereka Kod',
        ];
    }
}
