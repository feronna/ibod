<?php

namespace app\models\elnpt\elnpt2;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_v2_tbl_teknologi_inovasi".
 *
 * @property int $id
 * @property string $lpp_id
 * @property string $kategori
 * @property string $nama_projek
 * @property string $peranan
 * @property string $tahap_penyertaan
 * @property int $bil_impak
 * @property double $amaun
 */
class TblTeknologiInovasi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_v2_tbl_teknologi_inovasi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_id', 'bil_impak'], 'integer'],
            [['amaun'], 'number'],
            [['kategori', 'peranan', 'tahap_penyertaan'], 'string', 'max' => 50],
            [['nama_projek'], 'string', 'max' => 500],
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
            'bil_impak' => 'Bil Impak',
            'amaun' => 'Amaun',
        ];
    }
    
    public function getUser()
    {
        return $this->hasOne(\app\models\elnpt\TblMain::className(), ['lpp_id' => 'lpp_id']);
    }
}
