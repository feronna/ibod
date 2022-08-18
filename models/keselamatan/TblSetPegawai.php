<?php

namespace app\models\keselamatan;

use app\models\hronline\Campus;
use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "keselamatan.tbl_set_pegawai".
 *
 * @property int $id
 * @property string $anggota_icno
 * @property string $peraku_icno
 * @property string $pelulus_icno
 */
class TblSetPegawai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.tbl_set_pegawai';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pemohon_icno', 'peraku_icno', 'pelulus_icno'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'anggota_icno' => 'Anggota Icno',
            'peraku_icno' => 'Peraku Icno',
            'pelulus_icno' => 'Pelulus Icno',
        ];
    }
    public function getAnggota()
    {
        return $this->hasOne(Tblprcobiodata::class, ['ICNO' => 'pemohon_icno']);
    }
    // public function getStaff()
    // {
    //     return $this->hasOne(Tblprcobiodata::class, ['ICNO' => 'anggota_icno']);
    // }
    public function getPeraku()
    {
        return $this->hasOne(Tblprcobiodata::class, ['ICNO' => 'peraku_icno']);
    }
    public function getPelulus()
    {
        return $this->hasOne(Tblprcobiodata::class, ['ICNO' => 'pelulus_icno']);
    }
    public function getCamp()
    {
        return $this->hasOne(Campus::class, ['campus_id' => 'campus_id']);
    }
    public function getPemohon() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'pemohon_icno']);
    }

}
