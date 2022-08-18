<?php

namespace app\models\hronline;

use Yii;
use yii\helpers\Html;
/**
 * This is the model class for table "hronline.tbl_pap_tindakan".
 *
 * @property int $id
 * @property int $pap_ss_id fk tbl_pap_senarai_staf
 * @property int $jenis_akses ref_jenis_akses
 * @property string $tarikh_selesai
 * @property string $tandatangan nama staf
 * @property string $nama_staf nama staf y mengisi/mengemaskini
 * @property string $icno_staf icno staf y mengisi/mengemaskini
 */
class TblPapTindakan extends \yii\db\ActiveRecord
{
    public $status_AD = false;
    public $_action = null;

    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }

    public static function tableName()
    {
        return 'hronline.tbl_pap_tindakan';
    }

    public function rules()
    {
        return [
            [['pap_ss_id', 'jenis_akses'], 'integer'],
            [['penerangan','jenis_akses','status'], 'required','message'=>'Ruangan ini adalah mandatori.'],
            [['tarikh_selesai'], 'safe'],
            [['nama_staf'], 'string', 'max' => 255],
            [['icno_staf'], 'string', 'max' => 15],
            [['tandatangan'], 'string', 'max' => 100],
            [['status'], 'integer'],
            [['status_AD','_action'],'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pap_ss_id' => 'Pap Ss ID',
            'jenis_akses' => 'Jenis Akses',
            'tarikh_selesai' => 'Tarikh',
            'tandatangan' => 'Tandatangan',
            'nama_staf' => 'Nama Staf',
            'icno_staf' => 'Icno Staf',
        ];
    }

    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno_staf']);
    }
    public function getSenaraiStaf() {
        return $this->hasOne(TblPapSenaraiStaf::className(), ['id' => 'pap_ss_id']);
    }
    public function getAkses() {
        return $this->hasOne(RefPapJenisAkses::className(), ['id' => 'jenis_akses']);
    }
    public function getAksesI() {
        return $this->hasOne(TblPapAkses::className(), ['pap_ja_id' => 'jenis_akses']);
    }



     // public function afterSave($insert, $changedAttributes)
     public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);

        if ($this->_action == 'PGTindakan' && $this->status == 1) {
                $res = Yii::$app->MP->SendNotification([
                    'icno' => $this->senaraiStaf->icno,
                    'title' => 'Emel rasmi UMS anda telah didaftarkan.',
                    'content' => "Sila rujuk manual pengguna untuk tindakan seterusnya:
                    <p</b></p>
                    <p>Muat turun manual pengguna ".Html::a("<b>disini</b>", '/staff/web/uploads/hronline/lantikan/Manual_Pengguna_Emel_UMS.docx', ['target' => '_blank'])."</p>",
                    'date' => date('Y-m-d H:i:s') 
                ]);
                if($res[0] == true){
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Notifikasi telah dihantar kepada '.$this->senaraiStaf->icno]);
                }
        }

        return true;
    }
}
