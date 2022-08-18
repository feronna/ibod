<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_tbl_penyelidikan_manual".
 *
 * @property int $id
 * @property string $lpp_id
 * @property string $projek_id
 * @property string $tajuk_projek
 * @property string $peranan
 * @property string $pembiaya
 * @property string $kategori_pembiaya
 * @property double $jumlah_biaya
 * @property string $mula
 * @property string $tamat
 * @property string $status
 */
class TblPenyelidikanManual extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_tbl_penyelidikan_manual';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
//    public static function getDb()
//    {
//        return Yii::$app->get('db2');
//    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jumlah_biaya', 'mula', 'tamat', 'projek_id', 'tajuk_projek', 'peranan', 'pembiaya', 'kategori_pembiaya', 'status'], 'required'],
            [['lpp_id'], 'integer'],
            [['jumlah_biaya'], 'number'],
            [['mula', 'tamat'], 'safe'],
            [['projek_id'], 'string', 'max' => 10],
            [['tajuk_projek'], 'string', 'max' => 250],
            [['peranan', 'pembiaya', 'kategori_pembiaya', 'status'], 'string', 'max' => 50],
            [['jumlah_biaya'], 'default', 'value' => 0.00],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lpp_id' => 'Lpp ID',
            'projek_id' => 'Projek ID',
            'tajuk_projek' => 'Tajuk Projek',
            'peranan' => 'Peranan',
            'pembiaya' => 'Pembiaya',
            'kategori_pembiaya' => 'Kategori Pembiaya',
            'jumlah_biaya' => 'Jumlah Biaya',
            'mula' => 'Mula',
            'tamat' => 'Tamat',
            'status' => 'Status',
        ];
    }
}
