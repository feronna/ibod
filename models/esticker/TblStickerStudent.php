<?php

namespace app\models\esticker;

use yii\helpers\Html;
use app\models\esticker\TblPelekatKenderaanStudent;
use yii\data\ActiveDataProvider;
use Yii;

/**
 * This is the model class for table "e_sticker.sticker_staf".
 *
 * @property int $id
 * @property string $v_co_icno
 * @property string $veh_owner
 * @property string $veh_user
 * @property string $rel_owner_user
 * @property string $reg_number
 * @property string $veh_color
 * @property string $veh_type
 * @property string $veh_brand
 * @property string $veh_model
 * @property string $roadtax_no
 * @property string $roadtax_exp
 * @property string $apply_type
 * @property string $daftar_date 
 * @property string $updater
 * @property string $status_kenderaan
 * @property string $catatan 
 * @property string $filename_roadtax
 * @property string $filename_grant
 */
class TblStickerStudent extends \yii\db\ActiveRecord {

    public $no_siri;
    public $total;
    public $roadtax;
    public $grant;
    public $status_mohon;
    public $catatan2;
    public $mula;
    public $tamat;
    public $kod_siri, $siri, $booked;
    public $no_resit;

    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'keselamatan.stc_sticker_student';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['no_siri', 'total','no_resit'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['status_kenderaan', 'catatan', 'veh_owner', 'veh_user', 'rel_owner_user', 'reg_number', 'veh_color', 'veh_type', 'veh_brand', 'veh_model', 'roadtax_no', 'roadtax_exp', 'lesen_id'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['booked', 'kod_siri', 'roadtax_exp', 'daftar_date', 'roadtax', 'grant', 'status_mohon', 'catatan2', 'mula', 'tamat'], 'safe'],
            [['siri'], 'number'],
            [['siri'], 'string', 'min' => 6, 'max' => 6],
            [['total'], 'double'],
            [['lesen_id'], 'string', 'max' => 20],
            [['catatan'], 'string'],
            [['v_co_icno'], 'string', 'max' => 12],
            [['veh_owner', 'veh_user', 'filename_roadtax', 'filename_grant'], 'string', 'max' => 100],
            [['veh_type', 'apply_type','no_resit'], 'string', 'max' => 10],
            [['reg_number'], 'string', 'max' => 9],
            [['veh_color', 'rel_owner_user'], 'string', 'max' => 30],
            [['veh_brand', 'veh_model', 'roadtax_no'], 'string', 'max' => 50],
            [['updater', 'status_kenderaan'], 'string', 'max' => 15],
            [['reg_number'], 'unique'],
            [['roadtax', 'grant'], 'file', 'extensions' => 'pdf'],
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
            'filename_roadtax' => 'Fail Roadtax',
            'filename_grant' => 'Fail Kad Kereta',
        ];
    }

    public static function totalPending($category) {
        $count = TblPelekatKenderaanStudent::find()->where(['IN', 'status_mohon', $category])->andWhere(['deleted' => 0])->count();

        return '&nbsp;<span class="badge bg-red">' . $count . '</span>';
    }

    public function getKodSiri() {
        return $this->hasOne(\app\models\esticker\RefKodSiri::className(), ['veh_type' => 'veh_type'])->where(['stc_type' => 2]);
    }

    public function getPelekat() {
        return $this->hasOne(\app\models\esticker\TblPelekatKenderaanStudent::className(), ['id_kenderaan' => 'id']);
    }

    public function getBiodata() {
        return $this->hasOne(\app\models\esticker\User::className(), ['icno' => 'v_co_icno']);
    }

    public function getJeniskenderaan() {
        return $this->hasOne(\app\models\esticker\RefJenisKenderaan::className(), ['KODJENIS' => 'veh_type']);
    }

    public function getJenama() {
        return $this->hasOne(\app\models\esticker\RefJenamaKenderaan::className(), ['KODMODEL' => 'veh_brand']);
    }

    public static function findKenderaan($id) {
        return TblStickerStudent::find()->where(['stc_sticker_student.id' => $id])->joinWith('pelekat')->joinWith('biodata')->one();
    }

    public function findAkftifPermohonan($id) {
        return TblPelekatKenderaanStudent::find()->where(['id_kenderaan' => $id])->andWhere(['=', 'status_mohon', ['DIHANTAR', 'MENUNGGU KUTIPAN']])->andWhere(['deleted' => 0])->exists();
    }

    public function checkOwnKenderaan($reg_number) {
        return TblStickerStudent::find()->where(['stc_sticker_student.v_co_icno' => Yii::$app->user->identity->icno])->where(['LIKE', 'stc_sticker_student.reg_number', $reg_number])->exists();
    }

    public function getLesen() {
        return $this->hasOne(\app\models\esticker\Tbllesen::className(), ['LicNo' => 'lesen_id']);
    }

    public function lesen($id) {
        $model = \app\models\esticker\Tbllesen::findOne(['LicNo' => $id]);
        return $model->LicExpiryDt;
    }

    public function findlesenStudent($id) {
        return \app\models\esticker\Tbllesen::findOne(['LicNo' => $id]);
    }

//
//    public function lesen($id) {
//        $model = Tbllesen::findOne(['licId' => $id]);
//        return $model->LicExpiryDt;
//    }

    public function findGridKenderaan($title) {
        $data = TblPelekatKenderaanStudent::find()
                        ->joinWith('kenderaan')
                        ->where(['stc_sticker_student.v_co_icno' => Yii::$app->user->identity->icno])->all();
        $record = array();
        foreach ($data as $data) {
            $record[] = $data->kenderaan->reg_number;
        }

        if ($title == 'Permohonan Pelekat Baru') {
            $permohonan = TblStickerStudent::find()
                    ->where(['stc_sticker_student.v_co_icno' => Yii::$app->user->identity->icno])
                    ->andWhere(['stc_sticker_student.status_kenderaan' => ['AKTIF', 'TIDAK AKTIF']])
                    ->andWhere(['NOT IN', 'stc_sticker_student.reg_number', $record])
                    ->joinWith('jenama')
                    ->joinWith('jeniskenderaan')
                    ->joinWith('biodata')
                    ->all();
        } elseif ($title == 'Permohonan Pelekat Lanjutan') {
            $permohonan = TblStickerStudent::find()
                    ->where(['stc_sticker_student.v_co_icno' => Yii::$app->user->identity->icno])
                    ->andWhere(['stc_sticker_student.status_kenderaan' => ['AKTIF', 'TIDAK AKTIF']])
                    ->andWhere(['IN', 'stc_sticker_student.reg_number', $record])
                    ->joinWith('jenama')
                    ->joinWith('jeniskenderaan')
                    ->joinWith('biodata')
                    ->all();
        } elseif ($title == 'Semakan Permohonan') {
            $permohonan = TblPelekatKenderaanStudent::find()
                    ->joinWith('kenderaan')
                    ->where(['stc_sticker_student.v_co_icno' => Yii::$app->user->identity->icno])
                    ->andWhere(['stc_sticker_student.status_kenderaan' => 'AKTIF'])
                    ->andWhere(['stc_pelekat_kenderaan_student.deleted' => 0])
                    ->andWhere(['stc_pelekat_kenderaan_student.status_mohon' => ['DIHANTAR', 'MENUNGGU KUTIPAN']])
                    ->all();
        } elseif ($title == 'Arkib Permohonan') {
            $permohonan = TblPelekatKenderaanStudent::find()
                    ->joinWith('kenderaan')
                    ->where(['stc_sticker_student.v_co_icno' => Yii::$app->user->identity->icno])
                    ->andWhere(['stc_sticker_student.status_kenderaan' => ['AKTIF', 'TIDAK AKTIF']])
                    ->andWhere(['stc_pelekat_kenderaan_student.deleted' => 0])
                    ->andWhere(['stc_pelekat_kenderaan_student.status_mohon' => 'AKTIF'])
                    ->limit(10)
                    ->all();
        }

        return $permohonan;
    }

    public function Checking($id) {
        $check = TblStickerStudent::CheckTotalAktifSticker(); //CHECK LEBIH 3 PERMOHONAN

        $check1 = TblStickerStudent::CheckFile($id); //CHECK ROADTAX/GRANT TERKINI

        $check2 = TblStickerStudent::CheckLesenTamat($id); //CHECK LESEN EXPIRED 
        //1. Check kereta 'veh_type: KERETA,LORI,VAN'
        //2. Check motor 'veh_type: MOTOSIKAL,MOTORSIKAL MELEBIHI 125CC'
        //3. Check lesen OKU

        $check3 = TblStickerStudent::CheckRoadtaxTamat($id); //CHECK ROADTAX EXPIRED
        if ($check === true) {
            if ($check1 === true) {
                if ($check2 === true) {
                    if ($check3 === true) {
                        return true; //pass ALL condition
                    } else {
                        return TblStickerStudent::CheckRoadtaxTamat($id); // return error message
                    }
                } else {
                    return TblStickerStudent::CheckLesenTamat($id); // return error message
                }
            } else {
                return TblStickerStudent::CheckFile($id); // return error message
            }
        } else {
            return TblStickerStudent::CheckTotalAktifSticker(); // return error message
        }
    }

    public function CheckTotalAktifSticker() {
        $model = TblPelekatKenderaanStudent::findAllPelekat();
        $record = array();
        foreach ($model as $model) {
            if ($model->status_mohon == 'AKTIF') {
                if (date('Y-m-d') < $model->expired_date) {
                    $record[] = $model->kenderaan->reg_number;
                }
            } else {
                $record[] = $model->kenderaan->reg_number;
            }
        }

        $unique = array_unique($record);

        if (count($unique) < 3) {
            return true;
        } else {
            return 'Maaf anda mempunyai lebih daripada 3 permohonan aktif.';
        }
    }

    public function CheckFile($id) {
        $model = TblStickerStudent::findKenderaan($id);

        if (!empty($model->filename_roadtax && $model->filename_grant)) {
            return true;
        } else {
            return 'Sila muatnaik roadtax/kad kereta.';
        }
    }

    public function CheckLesenTamat($id) {
        $model = TblStickerStudent::findKenderaan($id);

//        if (!empty($model->lesen_id)) {
//            $lesen = Tbllesen::findOne(['licId' => $model->lesen_id]);
//
//            if ($lesen->kelasLesen->LicStickerType == $model->veh_type) {
//                if (date('Y-m-d') < $lesen->LicExpiryDt) {
//                    if (!empty($lesen->filename)) {
        return true;
//                    } else {
//                        return 'Maaf sila muatnaik lesen anda.';
//                    }
//                } else {
//                    return 'Maaf tarikh lesen anda telah tamat. Sila kemaskini maklumat lesen anda.';
//                }
//            } else {
//                return 'Maaf kelas lesen yang di gunakan tidak padan.';
//            }
//        } else {
//            return 'Maaf sila nyatakan jenis lesen bagi kenderaan ini.';
//        }
    }

    public function CheckRoadtaxTamat($id) {
        $model = TblStickerStudent::findKenderaan($id);

        if (date('Y-m-d') < $model->roadtax_exp) {
            return true;
        } else {
            return 'Maaf tarikh roadtax anda telah tamat. Sila kemaskini maklumat kenderaan anda.';
        }
    }

    public function findGridLesen() {

        $lesen = new ActiveDataProvider([
            'query' => Tbllesen::find()->where(['ICNO' => Yii::$app->user->identity->icno]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $lesen;
    }

    public function getDisplayLinkRoadtax() {
        if (!empty($this->filename_roadtax)) {
            return Html::a(Yii::$app->FileManager->NameFile($this->filename_roadtax), Yii::$app->FileManager->DisplayFile($this->filename_roadtax), ['target' => '_blank']);
        }
        return 'Tiada Maklumat!';
    }

    public function getDisplayLinkGrant() {
        if (!empty($this->filename_grant)) {
            return Html::a(Yii::$app->FileManager->NameFile($this->filename_grant), Yii::$app->FileManager->DisplayFile($this->filename_grant), ['target' => '_blank']);
        }
        return 'Tiada Maklumat!';
    }

    public function findStickerRate() {
        $max_veh = TblPelekatKenderaan::findPaymentRate('PRASISWAZAH'); //PRASISWAZAH/PASCASISWAZAH/PLUMS 
        return $max_veh->amount;
    }

}
