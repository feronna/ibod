<?php

namespace app\models\esticker;

use app\models\esticker\TblPelekatKenderaan;
use app\models\hronline\Tbllesen;
use yii\data\ActiveDataProvider;
use app\models\saman\SamanOld;
use Yii;

class TblStickerStaf extends \yii\db\ActiveRecord {

    public $no_siri;
    public $total;
    public $roadtax;
    public $grant;
    public $veh_front;
    public $veh_side;
    public $veh_rear;
    public $status_mohon;
    public $catatan2;
    public $mula;
    public $tamat;
    public $kod_siri, $siri, $booked;
    public $no_resit, $free;

    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'keselamatan.stc_sticker_staf';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['no_siri', 'total', 'no_resit'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['free', 'lesen_no', 'status_kenderaan', 'catatan', 'veh_owner', 'veh_user', 'rel_owner_user', 'reg_number', 'veh_color', 'veh_type', 'veh_brand', 'veh_model', 'roadtax_no', 'roadtax_exp', 'lesen'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['booked', 'kod_siri', 'roadtax_exp', 'daftar_date', 'status_mohon', 'catatan2', 'mula', 'tamat', 'catatan_modifikasi', 'index'], 'safe'],
            [['siri'], 'number'],
            [['siri'], 'string', 'min' => 6, 'max' => 6],
            [['lesen_no'], 'string', 'max' => 30],
            [['total'], 'double'],
            [['lesen_id'], 'integer'],
            [['catatan'], 'string'],
            [['v_co_icno'], 'string', 'max' => 12],
            [['catatan_modifikasi'], 'string', 'max' => 250],
            [['veh_owner', 'veh_user', 'filename_grant', 'filename_veh_front', 'filename_veh_side', 'filename_veh_rear'], 'string', 'max' => 100],
            [['veh_type', 'apply_type', 'no_resit'], 'string', 'max' => 10],
            [['reg_number'], 'string', 'max' => 9],
            [['veh_color', 'rel_owner_user'], 'string', 'max' => 30],
            [['veh_brand', 'veh_model', 'roadtax_no'], 'string', 'max' => 50],
            [['updater', 'status_kenderaan'], 'string', 'max' => 15],
            [['reg_number'], 'unique'],
            [['veh_front', 'veh_side', 'veh_rear'], 'file', 'extensions' => 'jpg,jpeg', 'maxSize' => 1024 * 1024 * 2],
            [['lesen', 'grant'], 'file', 'extensions' => 'pdf', 'maxSize' => 1024 * 1024 * 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'v_co_icno' => 'ICNO',
            'veh_owner' => 'Pemilik Kenderaan',
            'veh_user' => 'Pengguna Kenderaan',
            'rel_owner_user' => 'Hubungan',
            'reg_number' => 'No. Kereta',
            'veh_color' => 'Warna Kenderaan',
            'veh_type' => 'Jenis Kenderaan',
            'veh_brand' => 'Jenama Kenderaan',
            'veh_model' => 'Model Kenderaan',
            'roadtax_no' => 'No. Roadtax',
            'roadtax_exp' => 'Tarikh Tamat Roadtax',
            'apply_type' => 'Jenis Permohonan',
            'daftar_date' => 'Tarikh Daftar',
            'updater' => 'Updater',
            'status_kenderaan' => 'Status Kenderaan',
            'catatan' => 'Catatan',
            'catatan_modifikasi' => 'Catatan Modifikasi',
            'filename_grant' => 'Fail Kad Kereta',
            'filename_veh_front' => 'Gambar Kenderaan (Hadapan)',
            'filename_veh_side' => 'Gambar Kenderaan (Tepi)',
            'filename_veh_rear' => 'Gambar Kenderaan (Belakang)',
        ];
    }

    public static function totalPending($category) {
        $count = TblPelekatKenderaan::find()->where(['IN', 'status_mohon', $category])->andWhere(['deleted' => 0])->count();

        return '&nbsp;<span class="badge bg-red">' . $count . '</span>';
    }

    public static function totalPendingAll($category) {
        $count = TblPelekatKenderaan::find()->where(['IN', 'status_mohon', $category])->andWhere(['deleted' => 0])->count();
        $count2 = TblPelekatKenderaanJabatan::find()->where(['IN', 'status_mohon', $category])->andWhere(['deleted' => 0])->count();
        return '&nbsp;<span class="badge bg-red">' . ($count + $count2) . '</span>';
    }

    public function getPelekat() {
        return $this->hasOne(\app\models\esticker\TblPelekatKenderaan::className(), ['id_kenderaan' => 'id']);
    }

    public function getKodSiri() {
        if ($this->biodata->chiefDepartment) {
            $type = 7;
        } else {
            $type = 1;
        }
        return $this->hasOne(\app\models\esticker\RefKodSiri::className(), ['veh_type' => 'veh_type'])->where(['stc_type' => $type]);
    }

    public function getBiodata() {
        return $this->hasOne(\app\models\hronline\tblprcobiodata::className(), ['ICNO' => 'v_co_icno']);
    }

    public function getJeniskenderaan() {
        return $this->hasOne(\app\models\esticker\RefJenisKenderaan::className(), ['KODJENIS' => 'veh_type']);
    }

    public function getJenama() {
        return $this->hasOne(\app\models\esticker\RefJenamaKenderaan::className(), ['KODMODEL' => 'veh_brand']);
    }

    public static function findKenderaan($id) {
        return TblStickerStaf::find()->where(['stc_sticker_staf.id' => $id])->joinWith('pelekat')->joinWith('biodata')->one();
    }

    public function findAkftifPermohonan($id) {
        return TblPelekatKenderaan::find()->where(['id_kenderaan' => $id])->andWhere(['=', 'status_mohon', ['DIHANTAR', 'MENUNGGU KUTIPAN']])->andWhere(['deleted' => 0])->exists();
    }

    public static function indexKenderaan() {
        $model = TblStickerStaf::find()->where(['stc_sticker_staf.v_co_icno' => Yii::$app->user->getId()])->count();

        return $model ? ($model + 1) : 1;
    }

    public static function checkOwnKenderaan($reg_number) {
        return TblStickerStaf::find()->where(['stc_sticker_staf.v_co_icno' => Yii::$app->user->getId()])->andWhere(['LIKE', 'stc_sticker_staf.reg_number', $reg_number])->exists();
    }
    
    public static function checkElseOwnKenderaan($reg_number) {
        return TblStickerStaf::find()->where(['LIKE', 'stc_sticker_staf.reg_number', $reg_number])->exists();
    }

    public function getlesen($id) {
        return Tbllesen::findOne(['licId' => $id]);
    }

    public function lesen($id) {
        $model = Tbllesen::findOne(['licId' => $id]);
        return $model->LicExpiryDt;
    }

    public static function findGridKenderaan($title) {
        $data = TblPelekatKenderaan::find()
                ->joinWith('kenderaan')
                ->where(['stc_sticker_staf.v_co_icno' => Yii::$app->user->getId()])
                ->andWhere(['stc_pelekat_kenderaan.status_mohon' => ['AKTIF', 'MENUNGGU KUTIPAN', 'DITOLAK', 'MENUNGGU BAYARAN KAUNTER']])
                ->all();
        $record = array();
        foreach ($data as $data) {
            $record[] = $data->kenderaan->reg_number;
        }

        if ($title == 'Permohonan Pelekat Baru') {
            $query = TblStickerStaf::find()
                    ->where(['stc_sticker_staf.v_co_icno' => Yii::$app->user->getId()])
                    ->andWhere(['stc_sticker_staf.status_kenderaan' => ['AKTIF', 'TIDAK AKTIF']])
                    ->andWhere(['NOT IN', 'stc_sticker_staf.reg_number', $record])
                    ->joinWith('jenama')
                    ->joinWith('jeniskenderaan')
                    ->joinWith('biodata');
        } elseif ($title == 'Permohonan Pelekat Lanjutan') {
            $query = TblStickerStaf::find()
                    ->where(['stc_sticker_staf.v_co_icno' => Yii::$app->user->getId()])
                    ->andWhere(['stc_sticker_staf.status_kenderaan' => ['AKTIF', 'TIDAK AKTIF']])
                    ->andWhere(['IN', 'stc_sticker_staf.reg_number', $record])
                    ->joinWith('jenama')
                    ->joinWith('jeniskenderaan')
                    ->joinWith('biodata');
        } elseif ($title == 'Semakan Permohonan') {
            $query = TblPelekatKenderaan::find()
                    ->joinWith('kenderaan')
                    ->where(['stc_sticker_staf.v_co_icno' => Yii::$app->user->getId()])
                    ->andWhere(['stc_sticker_staf.status_kenderaan' => 'AKTIF'])
                    ->andWhere(['stc_pelekat_kenderaan.deleted' => 0])
                    ->andWhere(['stc_pelekat_kenderaan.batal' => 0])
                    ->andWhere(['stc_pelekat_kenderaan.status_mohon' => ['MENUNGGU BAYARAN KAUNTER', 'PENDING PAYMENT', 'MENUNGGU KUTIPAN', 'DITOLAK']]);
        } elseif ($title == 'Arkib Permohonan') {
            $query = TblPelekatKenderaan::find()
                    ->joinWith('kenderaan')
                    ->where(['stc_sticker_staf.v_co_icno' => Yii::$app->user->getId()])
                    ->andWhere(['stc_sticker_staf.status_kenderaan' => ['AKTIF', 'TIDAK AKTIF']])
                    ->andWhere(['stc_pelekat_kenderaan.deleted' => 0])
                    ->andWhere(['stc_pelekat_kenderaan.batal' => 0])
                    ->andWhere(['stc_pelekat_kenderaan.status_mohon' => 'AKTIF']);
        }

        $permohonan = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $permohonan;
    }

    public static function Checking($id) {
        $check = TblStickerStaf::CheckTotalAktifSticker(); //CHECK LEBIH 3 PERMOHONAN
        // $check1 = TblStickerStaf::CheckFile($id); //CHECK ROADTAX/GRANT TERKINI
        // $check2 = TblStickerStaf::CheckLesenTamat($id); //CHECK LESEN EXPIRED 
        $check2 = TblStickerStaf::CheckKenderaan3Self($id); //CHECK LESEN EXPIRED 
        //1. Check kereta 'veh_type: KERETA,LORI,VAN'
        //2. Check motor 'veh_type: MOTOSIKAL,MOTORSIKAL MELEBIHI 125CC'
        //3. Check lesen OKU

        $check3 = TblStickerStaf::CheckRoadtaxTamat($id); //CHECK ROADTAX EXPIRED

        $check4 = TblStickerStaf::CheckRecordSaman($id); //CHECK RECORD SAMAN
        if ($check === true) {
//            if ($check1 === true) {
            if ($check2 === true) {
                if ($check3 === true) {
                    if ($check4 === true) {
                        return true; //pass ALL condition
                    } else {
                        return TblStickerStaf::CheckRecordSaman($id); // return error message
                    }
                } else {
                    return TblStickerStaf::CheckRoadtaxTamat($id); // return error message
                }
            } else {
                return TblStickerStaf::CheckKenderaan3Self($id); // return error message
            }
//            } else {
//                return TblStickerStaf::CheckFile($id); // return error message
//            }
        } else {
            return TblStickerStaf::CheckTotalAktifSticker(); // return error message
        }
    }

    public static function CheckTotalAktifSticker() {
        $model = TblPelekatKenderaan::findAllPelekat();
        $max_veh = TblPelekatKenderaan::findPaymentRate('STAFF');
        $i = 0;
        foreach ($model as $model) {
            if ($model->status_mohon == 'AKTIF') {
                if (date('Y-m-d') < $model->expired_date_2) {
                    $i++;
                }
            }
            //sedang diproses
            if ($model->status_mohon == 'DIHANTAR') { 
                    $i++; 
            }
        }

        if ($i <= $max_veh->maximum) {
            return true;
        } else {
            return 'Maaf anda mempunyai lebih daripada ' . $max_veh->maximum . ' permohonan aktif.';
        }
    }

    public static function CheckFile($id) {
        $model = TblStickerStaf::findKenderaan($id);

        if (!empty($model->filename_grant)) {
            return true;
        } else {
            return 'Sila muatnaik kad kereta.';
        }
    }

    public static function CheckRecordSaman($id) {
        $model = SamanOld::find()->joinWith('saman')
                        ->where(['t_02_eks_saman.ICNO' => Yii::$app->user->getId()])
                        ->andWhere(['t_19_eks_bayar.STATUS' => 'PENDING'])->one();
        $kenderaan = TblStickerStaf::findKenderaan($id);
        $model2 = SamanOld::find()->joinWith('saman')
                        ->where(['t_02_eks_saman.NO_KENDERAAN' => $kenderaan->reg_number])
                        ->andWhere(['t_19_eks_bayar.STATUS' => 'PENDING'])->one();

        if (empty($model) && empty($model2)) {
            return true;
        } else {
            return 'Maaf anda mempunyai rekod saman, sila jelaskan bayaran saman di kaunter Bahagian Kesemalatan.';
        }
    }

    public static function CheckLesenTamat($id) {
        $model = TblStickerStaf::findKenderaan($id);

        if (!empty($model->lesen_id)) {
            $lesen = Tbllesen::findOne(['licId' => $model->lesen_id]);

            if ($lesen->kelasLesen->LicStickerType == $model->veh_type) {
                if (date('Y-m-d') < $lesen->LicExpiryDt) {
                    if (!empty($lesen->filename)) {
                        return true;
                    } else {
                        return 'Maaf sila muatnaik lesen anda.';
                    }
                } else {
                    return 'Maaf tarikh lesen anda telah tamat. Sila kemaskini maklumat lesen anda.';
                }
            } else {
                return 'Maaf kelas lesen yang di gunakan tidak padan.';
            }
        } else {
            return 'Maaf sila nyatakan jenis lesen bagi kenderaan ini.';
        }
    }

    public static function CheckRoadtaxTamat($id) {
        $model = TblStickerStaf::findKenderaan($id);

        if (date('Y-m-d') < $model->roadtax_exp) {
            return true;
        } else {
            return 'Maaf tarikh roadtax anda telah tamat. Sila kemaskini maklumat kenderaan anda.';
        }
    }

    public static function CheckKenderaan3Self($id) {

        $kenderaan = TblStickerStaf::findKenderaan($id);
        $model = TblPelekatKenderaan::findAllPelekat();
        $i = 0;
        foreach ($model as $model) {
            if ($model->status_mohon == 'AKTIF' && $model->id_kenderaan != $kenderaan->id) {//rosak lanjutan
                if (date('Y-m-d') < $model->expired_date_2) {
                    $i++;
                }
            }
        }

        if ($i >= 2) {
            if ($kenderaan->rel_owner_user == 'DIRI SENDIRI') {
                return true;
            } else {
                return 'Maaf kenderaan ketiga yang didaftarkan mestilah kenderaan milik sendiri.';
            }
        } else {
            return true;
        }
    }

    public function findGridLesen() {

        $lesen = new ActiveDataProvider([
            'query' => Tbllesen::find()->where(['ICNO' => Yii::$app->user->getId()]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $lesen;
    }
    
     public static function findGridSaman($type) {
         
        $kenderaan = TblStickerStaf::find()->where(['v_co_icno' => Yii::$app->user->getId()])->all();
        $reg_number = array();
        
        foreach($kenderaan as $k){
            $reg_number[] = $k->reg_number;
        }
        
        if($type=='PENDING'){
            $query = SamanOld::find()->joinWith('saman')
                    ->where(['IN','t_02_eks_saman.NO_KENDERAAN' ,$reg_number])
                    ->andWhere(['t_19_eks_bayar.STATUS'=>'PENDING']);
        }else{
            $query = SamanOld::find()->joinWith('saman')
                    ->where(['IN','t_02_eks_saman.NO_KENDERAAN',$reg_number])
                    ->andWhere(['t_19_eks_bayar.STATUS'=>'PAID']);
        }
    
        $saman = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $saman;
    }

}
