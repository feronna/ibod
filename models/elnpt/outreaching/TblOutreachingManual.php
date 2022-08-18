<?php

namespace app\models\elnpt\outreaching;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_tbl_outreaching_manual".
 *
 * @property int $id
 * @property string $lpp_id
 * @property string $kategori
 * @property string $nama_projek
 * @property string $peranan
 * @property string $tahap_penyertaan
 * @property double $amaun
 */
class TblOutreachingManual extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_tbl_outreaching_manual';
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
            [['lpp_id'], 'integer'],
            [['amaun'], 'number'],
            [['kategori', 'peranan', 'tahap_penyertaan'], 'string', 'max' => 200],
            [['nama_projek'], 'string', 'max' => 500],
            [['kategori', 'nama_projek', 'peranan', 'tahap_penyertaan', 'amaun'], 'required'],
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
            'nama_projek' => 'Nama Projek',
            'peranan' => 'Peranan',
            'tahap_penyertaan' => 'Tahap Penyertaan',
            'amaun' => 'Amaun',
        ];
    }
}
