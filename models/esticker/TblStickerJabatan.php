<?php

namespace app\models\esticker;

use yii\data\ActiveDataProvider;
use Yii;

/**
 * This is the model class for table "{{%keselamatan.stc_sticker_jabatan}}".
 *
 * @property int $id
 * @property string $v_co_icno
 * @property string $reg_number
 * @property string $veh_color
 * @property string $veh_type
 * @property string $veh_brand
 * @property string $veh_model
 * @property string $roadtax_no
 * @property string $roadtax_exp
 * @property string $daftar_date
 * @property string $updater
 * @property string $status_kenderaan
 * @property int $lesen_no
 * @property string $catatan_modifikasi
 */
class TblStickerJabatan extends \yii\db\ActiveRecord {

    public $no_siri;  
    public $mula;
    public $tamat;
    public $kod_siri, $siri;
    public $no_resit;
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%keselamatan.stc_sticker_jabatan}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['v_co_icno','reg_number','veh_color','veh_type','veh_brand','veh_model','lesen_no','roadtax_no','roadtax_exp','no_siri','siri','no_resit'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['no_resit','roadtax_exp', 'daftar_date', 'dept_id', 'catatan','mula', 'tamat','kod_siri','no_siri'], 'safe'],
            [['siri'], 'number'],
            [['siri'], 'string', 'min' => 6, 'max' => 6],
            [['lesen_no'], 'integer'],
            [['v_co_icno'], 'string', 'max' => 12],
            [['reg_number'], 'string', 'max' => 9],
            [['veh_color'], 'string', 'max' => 30],
            [['veh_type'], 'string', 'max' => 10],
            [['veh_brand', 'veh_model', 'roadtax_no'], 'string', 'max' => 50],
            [['updater', 'status_kenderaan'], 'string', 'max' => 15],
            [['catatan_modifikasi'], 'string', 'max' => 250],
            [['reg_number'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'v_co_icno' => 'V Co Icno',
            'reg_number' => 'Reg Number',
            'veh_color' => 'Veh Color',
            'veh_type' => 'Veh Type',
            'veh_brand' => 'Veh Brand',
            'veh_model' => 'Veh Model',
            'roadtax_no' => 'Roadtax No',
            'roadtax_exp' => 'Roadtax Exp',
            'daftar_date' => 'Daftar Date',
            'updater' => 'Updater',
            'status_kenderaan' => 'Status Kenderaan',
            'lesen_no' => 'Lesen No',
            'catatan_modifikasi' => 'Catatan Modifikasi',
        ];
    }

    public static function checkOwnKenderaan($reg_number) {
        return TblStickerJabatan::find()->where(['LIKE', 'stc_sticker_jabatan.reg_number', $reg_number])->exists();
    } 

    public function getBiodata() {
        return $this->hasOne(\app\models\hronline\tblprcobiodata::className(), ['ICNO' => 'v_co_icno']);
    }
    
    public function getDepartment() {
        return $this->hasOne(\app\models\hronline\Department::className(), ['id' => 'dept_id']);
    }
    
    public function getPelekat() {
        return $this->hasOne(\app\models\esticker\TblPelekatKenderaanJabatan::className(), ['id_kenderaan' => 'id']);
    }

    public static function findKenderaan($id) {
        return TblStickerJabatan::find()->where(['stc_sticker_jabatan.id' => $id])->joinWith('pelekat')->joinWith('biodata')->one();
    }

    public function findCurrentDept() {
        $model = \app\models\hronline\Tblprcobiodata::find()->where(['ICNO' => Yii::$app->user->getId()])->one();

        return $model->DeptId;
    }

    public function getJeniskenderaan() {
        return $this->hasOne(\app\models\esticker\RefJenisKenderaan::className(), ['KODJENIS' => 'veh_type']);
    }

    public function getJenama() {
        return $this->hasOne(\app\models\esticker\RefJenamaKenderaan::className(), ['KODMODEL' => 'veh_brand']);
    }
    
     public function findAkftifPermohonan($id) {
        return TblPelekatKenderaanJabatan::find()->where(['id_kenderaan' => $id])->andWhere(['=', 'status_mohon', ['MENUNGGU KUTIPAN']])->andWhere(['deleted' => 0])->exists();
    }
    
    public function getKodSiri() { 
        return $this->hasOne(\app\models\esticker\RefKodSiri::className(), ['veh_type' => 'veh_type'])->where(['stc_type' => 8]);
    }

    public static function findGridKenderaan($title) {
        //find current dept 
        $model = \app\models\hronline\Tblprcobiodata::find()->where(['ICNO' => Yii::$app->user->getId()])->one();
        $curent_dept = $model->DeptId;

        $data = TblPelekatKenderaanJabatan::find()
                ->joinWith('kenderaan')
                ->where(['stc_sticker_jabatan.dept_id' => $curent_dept])
                ->andWhere(['stc_pelekat_kenderaan_jabatan.status_mohon' => ['AKTIF', 'MENUNGGU KUTIPAN']])
                ->all();
        $record = array();
        foreach ($data as $data) {
            $record[] = $data->kenderaan->reg_number;
        }

        if ($title == 'Permohonan Pelekat Baru') {
            $query = TblStickerJabatan::find()
                    ->where(['stc_sticker_jabatan.dept_id' => $curent_dept])
                    ->andWhere(['stc_sticker_jabatan.status_kenderaan' => ['AKTIF', 'TIDAK AKTIF']])
                    ->andWhere(['NOT IN', 'stc_sticker_jabatan.reg_number', $record])
                    ->joinWith('jenama')
                    ->joinWith('jeniskenderaan')
                    ->joinWith('biodata');
        } elseif ($title == 'Permohonan Pelekat Lanjutan') {
            $query = TblStickerJabatan::find()
                    ->where(['stc_sticker_jabatan.dept_id' => $curent_dept])
                    ->andWhere(['stc_sticker_jabatan.status_kenderaan' => ['AKTIF', 'TIDAK AKTIF']])
                    ->andWhere(['IN', 'stc_sticker_jabatan.reg_number', $record])
                    ->joinWith('jenama')
                    ->joinWith('jeniskenderaan')
                    ->joinWith('biodata');
        } elseif ($title == 'Semakan Permohonan Jabatan') {
            $query = TblPelekatKenderaanJabatan::find()
                    ->joinWith('kenderaan')
                    ->where(['stc_sticker_jabatan.dept_id' => $curent_dept])
                    ->andWhere(['stc_sticker_jabatan.status_kenderaan' => 'AKTIF'])
                    ->andWhere(['stc_pelekat_kenderaan_jabatan.deleted' => 0])
                    ->andWhere(['stc_pelekat_kenderaan_jabatan.batal' => 0])
                    ->andWhere(['stc_pelekat_kenderaan_jabatan.status_mohon' => ['MENUNGGU KUTIPAN']]);
        } elseif ($title == 'Arkib Permohonan Jabatan') {
            $query = TblPelekatKenderaanJabatan::find()
                    ->joinWith('kenderaan')
                    ->where(['stc_sticker_jabatan.dept_id' => $curent_dept])
                    ->andWhere(['stc_sticker_jabatan.status_kenderaan' => ['AKTIF', 'TIDAK AKTIF']])
                    ->andWhere(['stc_pelekat_kenderaan_jabatan.deleted' => 0])
                    ->andWhere(['stc_pelekat_kenderaan_jabatan.batal' => 0])
                    ->andWhere(['stc_pelekat_kenderaan_jabatan.status_mohon' => 'AKTIF']);
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
        $check3 = TblStickerJabatan::CheckRoadtaxTamat($id); //CHECK ROADTAX EXPIRED

        $check4 = TblStickerJabatan::CheckRecordSaman(); //CHECK RECORD SAMAN 

        if ($check3 === true) {
            if ($check4 === true) {
                return true; //pass ALL condition
            } else {
                return TblStickerJabatan::CheckRecordSaman(); // return error message
            }
        } else {
            return TblStickerJabatan::CheckRoadtaxTamat($id); // return error message
        }
    }
    
     public static function CheckRoadtaxTamat($id) {
        $model = TblStickerJabatan::findKenderaan($id);

        if (date('Y-m-d') < $model->roadtax_exp) {
            return true;
        } else {
            return 'Maaf tarikh roadtax anda telah tamat. Sila kemaskini maklumat kenderaan anda.';
        }
    }
    
        public static function CheckRecordSaman() {
        $model = \app\models\saman\SamanOld::find()->joinWith('saman')
                        ->where(['t_02_eks_saman.ICNO' => Yii::$app->user->getId()])
                        ->andWhere(['t_19_eks_bayar.STATUS' => 'PENDING'])->one();

        if (empty($model)) {
            return true;
        } else {
            return 'Maaf anda mempunyai rekod saman, sila jelaskan bayaran saman di kaunter Bahagian Kesemalatan.';
        }
    }
    
    public static function totalPending($category) {
        $count = TblPelekatKenderaanJabatan::find()->where(['IN', 'status_mohon', $category])->andWhere(['deleted' => 0])->count();

        return '&nbsp;<span class="badge bg-red">' . $count . '</span>';
    }
}
