<?php

namespace app\models\w_letter;

use Yii;

/**
 * This is the model class for table "hrm.wl_tbl_permohonan_ppv".
 *
 * @property int $id
 * @property string $ICNO
 * @property string $StartDate
 * @property string $EndDate
 * @property string $approved_bsm_at
 * @property string $approved_bsm_by
 * @property int $status_notifikasi
 * @property string $tarikh_notifikasiis
 * @property int $Active
 */
class TblPermohonanPpv extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.wl_tbl_permohonan_ppv';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['StartDate', 'EndDate', 'approved_bsm_at', 'tarikh_notifikasi','StartTime','time_id'], 'safe'],
            [['status_notifikasi', 'isActive'], 'integer'],
            [['ICNO', 'approved_bsm_by'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'StartDate' => 'Start Date',
            'EndDate' => 'End Date',
            'approved_jfpiu_at' => 'Approved Bsm At',
            'approved_jfpiu_by' => 'Approved Bsm By',
            'status_notifikasi' => 'Status Notifikasi',
            'tarikh_notifikasi' => 'Tarikh Notifikasiis',
            'isActive' => 'Active',
        ];
    }
    
    public function Pegawai() {
        return \app\models\cuti\TblManagement::find()->where(['user' => 'eSurat'])->andWhere(['level'=>1])->one();
    }
    
    public function getBiodata() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }
    
    public function findCardColor($id) {

        $data = \app\models\umsshield\SelfRisk::find()->where(['icno' => $id])->orderBy(['assessmentTaken' => SORT_DESC])->One();
        if ($data) {
            if ($data->riskGroupId == 2 || $data->riskGroupId == 3) {
                return '<strong><span class="required" style="color:red;">MERAH</span></strong>';
            } elseif ($data->riskGroupId == 4) {
                return '<strong><span class="required" style="color:yello;">KUNING</span></strong>';
            } elseif ($data->riskGroupId == 6) {
                return '<strong><span class="required" style="color:green;">HIJAU</span></strong>';
            } else {
                return '-';
            }
        } else {
            return '-';
        }
    }
    
    public function isChief() {
        return \app\models\hronline\Department::findOne(['chief' => $this->ICNO]);
    }

    public function isChiefBsm() {
        $model = \app\models\hronline\Department::find()->where(['shortname'=>'BSM'])->one();
        
        return $model ? $model->chief: "";
    }
    
     public function Bsm() {
        return \app\models\hronline\Tblprcobiodata::find()->joinWith('chiefDepartment')->andWhere(['department.shortname'=>'BSM'])->one();
    }
    
    public function Pendaftar() {
        return \app\models\hronline\Tblprcobiodata::find()->joinWith('chiefDepartment')->andWhere(['department.shortname'=>'PN'])->one();
    }
}
