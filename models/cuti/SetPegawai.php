<?php

namespace app\models\cuti;

use Yii;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "e_cuti.set_pegawai".
 *
 * @property string $set_pegawai_id
 * @property string $pemohon_icno
 * @property int $jenis_cuti_id
 * @property string $peraku_icno
 * @property string $pelulus_icno
 * @property string $peg_all
 * @property string $penyelia_set_icno
 * @property string $set_datestamp
 * @property int $set_status 1 = yes, 0 = false/outdated
 */
class SetPegawai extends \yii\db\ActiveRecord
{

    // add the function below:
    // public static function getDb() {
    //     return Yii::$app->get('db2'); // second database
    // }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cuti_set_pegawai';
        // return 'e_cuti.set_pegawai';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenis_cuti_id', 'set_status'], 'integer'],
            [['set_datestamp'], 'safe'],
            [['pemohon_icno', 'peraku_icno', 'pelulus_icno', 'peg_all', 'penyelia_set_icno'], 'string', 'max' => 14],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'set_pegawai_id' => 'Set Pegawai ID',
            'pemohon_icno' => 'Pemohon Icno',
            'jenis_cuti_id' => 'Jenis Cuti ID',
            'peraku_icno' => 'Peraku Icno',
            'pelulus_icno' => 'Pelulus Icno',
            'peg_all' => 'Peg All',
            'penyelia_set_icno' => 'Penyelia Set Icno',
            'set_datestamp' => 'Set Datestamp',
            'set_status' => 'Set Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeraku()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'peraku_icno']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPemohon()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'pemohon_icno']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPelulus()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'pelulus_icno']);
    }


    public static function DisplayPeraku($icno)
    {

        $val = '-';

        $model = SetPegawai::findOne(['pemohon_icno' => $icno]);

        if ($model) {

            $val = $model->peraku_icno == NULL ? 'TERUS KEPADA PEGAWAI MELULUS' : $model->peraku->CONm;
        }

        return $val;
    }

    public static function DisplayPelulus($icno)
    {

        $val = '-';

        $model = SetPegawai::findOne(['pemohon_icno' => $icno]);

        if ($model) {

            $val = $model->pelulus_icno == NULL ? 'N/A' : $model->pelulus->CONm;
        }

        return $val;
    }

    /**
     * Update semua pelulus yg berkaitan perubahan lantikan pentadbiran 
     * 
     * $kj_icno = icno
     * 
     * return boolean
     * 
     */
    public static function autoUpdatePelulus($kj_icno)
    {

        if ($kj_icno) {
            return true;
        }


        return false;
    }
}
