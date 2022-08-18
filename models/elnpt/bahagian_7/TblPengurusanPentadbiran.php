<?php

namespace app\models\elnpt\bahagian_7;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_tbl_urus_tadbir".
 *
 * @property int $id
 * @property string $lpp_id
 * @property string $kategori
 * @property string $nama_jawatan
 * @property string $peranan
 * @property string $tahap_lantikan
 */
class TblPengurusanPentadbiran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_tbl_urus_tadbir';
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
            [['lpp_id', 'isElaun'], 'integer'],
            [['kategori', 'peranan', 'tahap_lantikan'], 'string', 'max' => 200],
            [['nama_jawatan'], 'string', 'max' => 100],
            [['isElaun'], 'safe'],
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
            'kategori' => 'Kategori',
            'nama_jawatan' => 'Nama Jawatan',
            'peranan' => 'Peranan',
            'tahap_lantikan' => 'Tahap Lantikan',
            'isElaun' => 'Berelaun?',
        ];
    }
}
