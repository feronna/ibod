<?php

namespace app\models\Pergigian;
use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "pergigian.tbl_pegawai".
 *
 * @property int $id
 * @property int $penyemak_icno
 * @property int $pelulus_icno
 * @property int $bendahari_icno
 */
class Pegawai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    
    
    
    public static function tableName()
    {
        return 'hrm.gigi_tbl_pegawai';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penyemak_icno', 'pelulus_icno', 'bendahari_icno','pendaftar'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'penyemak_icno' => 'Penyemak Icno',
            'pelulus_icno' => 'Pelulus Icno',
            'bendahari_icno' => 'Bendahari Icno',
            'pendaftar' => 'pendaftar',
        ];
    }
    
    public function getPelulus()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'pelulus_icno']);
    }
}
