<?php

namespace app\models\klinikpanel;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;

use Yii;

/**
 * This is the model class for table "hrm.myhealth_tblmohon".
 *
 * @property int $id
 * @property string $icno
 * @property int $entry_id 1=1st pmohonan, 2=2nd
 * @property int $status 0= entry, 1=verify, 2=approved
 * @property string $entry_dt
 * @property string $entry_remarks
 * @property string $verify_dt
 * @property string $verify_by
 * @property string $verify_remarks
 * @property string $app_dt
 * @property string $app_by
 * @property string $app_remarks
 */
class Tblmohon extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.myhealth_tblmohon';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['entry_id', 'status','status_check','status_ver','status_verifybsm','status_app','dependent','dept_id'], 'integer'],
            [['jumlah_mohon','app_amount'], 'number'],
            [['app_amount'], 'required'],
            [['entry_dt','check_dt', 'verify_dt','verifybsm_dt', 'app_dt','checkbox','checkboxs'], 'safe'],
            [['icno', 'check_by','verify_by', 'verifybsm_by','app_by'], 'string', 'max' => 15],
            [['entry_remarks', 'check_remarks','verify_remarks', 'app_remarks'], 'string', 'max' => 255],
            [['entry_remarks', 'check_remarks','verify_remarks','verifybsm_remarks', 'app_remarks'], 'required','message' => 'Ruang ini adalah mandatori'],
            [['status'],'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'entry_id' => 'Entry ID',
            'jumlah_mohon' => 'Jumlah Permohonan',
            'status' => 'Status',
            'entry_dt' => 'Entry Dt',
            'entry_remarks' => 'Entry Remarks',
            'verify_dt' => 'Verify Dt',
            'verify_by' => 'Verify By',
            'verify_remarks' => 'Verify Remarks',
            'app_dt' => 'App Dt',
            'app_by' => 'App By',
            'app_remarks' => 'App Remarks',
        ];
    }
    
    public function getKakitangan()
    {
        return $this->hasOne(Tblmaxtuntutan::className(), ['max_icno' => 'icno']);
    }

    public function getBiodata() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'icno'])->andOnCondition(['!=','hronline.tblprcobiodata.Status','6']);
    }

    public function getDepartment(){
        return $this->hasOne(Department::className(),['id' => 'dept_id']);
    }
    
    public function getVerifier()
    {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(),['ICNO' => 'verify_by']);
    }
    
    public function getChecker()
    {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(),['ICNO' => 'check_by']);
    }
    
    public function getApprover()
    {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(),['ICNO' => 'app_by']);
    }

    public function getVerifierBsm()
    {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(),['ICNO' => 'verifybsm_by']);
    }

    public function getPermohonan(){
        if ($this->entry_id == 1){
            return '<span class="label label-primary">PERTAMA</span>';
        }
        if ($this->entry_id == 2){
            return '<span class="label label-info">KEDUA</span>';
        }

    }

    public function getPermohonanR(){
        if ($this->entry_id == 1){
            return 'PERTAMA';
        }
        if ($this->entry_id == 2){
            return 'KEDUA';
        }

    }
    
    public function getStatusS() {
        if ($this->status == 0) {
            return '<span class="label label-warning">BARU</span>';
        }
        if ($this->status == 1) {
            return '<span class="label label-info">DIPERAKU</span>';
        }
        if ($this->status == 2) {
            return '<span class="label label-primary">DISEMAK</span>';
        }
        if ($this->status == 3) {
            return '<span class="label label-success">DILULUSKAN</span>';
        }
        if ($this->status == 4) {
            return '<span class="label label-danger">DITOLAK</span>';
        }
        if ($this->status == 5) {
            return '<span class="label label-success">DIPERAKU BSM</span>';
        }
    }

    public function getStatusE() {
        if ($this->status == 0) {
            return 'BARU';
        }
        if ($this->status == 1) {
            return 'DIPERAKU';
        }
        if ($this->status == 2) {
            return 'DISEMAK';
        }
        if ($this->status == 3) {
            return 'DILULUSKAN';
        }
        if ($this->status == 4) {
            return 'DITOLAK';
        }
        if ($this->status == 5) {
            return 'DIPERAKU BSM';
        }
    }
    
    public function getStatusV() {
        if ($this->status_ver == 1) {
            return '<span class="label label-info">DIPERAKU</span>';
        }
        if ($this->status_ver == 4) {
            return '<span class="label label-danger">DITOLAK</span>';
        }
    }
    
    public function getStatusC() {
        if ($this->status_check == 2) {
            return '<span class="label label-primary">DISEMAK</span>';
        }
        if ($this->status_check == 4) {
            return '<span class="label label-danger">DITOLAK</span>';
        }
    }

    public function getStatusB(){
        if ($this->status_verifybsm == 5) {
            return '<span class="label label-success">DIPERAKU BSM</span>';
        }
        if ($this->status_verifybsm == 4) {
            return '<span class="label label-danger">DITOLAK</span>';
        }
    }
    
    public function getStatusA() {
        if ($this->status_app == 3) {
            return '<span class="label label-success">DILULUSKAN</span>';
        }
        if ($this->status_app == 4) {
            return '<span class="label label-danger">DITOLAK</span>';
        }
    }

    public static function totalPendingVerify($icno)
    {
        $model =Tblmohon::find()->one();
        $biodata = Tblprcobiodata::findOne(['ICNO' => $model->icno]);
        $kj = Department::findOne(['id' => $biodata->DeptId]);
        $nc = Department::findOne(['chief' => '700827125563']);

        if($model->icno == $kj->chief){

            $count = self::find()
            ->where(['verify_by' => $nc, 'status' => '0'])
            ->asArray()
            ->count('id');
            
        return $count;
        }else {
        $count = self::find()
            ->where(['verify_by' => $icno, 'status' => '0'])
            ->asArray()
            ->count('id');

        return $count;
        }
    }

    public static function totalPendingCheck($icno)
    {
        $count = self::find()
            ->where(['check_by' => $icno, 'status' => '1'])
            ->asArray()
            ->count('id');

        return $count;
    }

    // public static function totalPendingApprove($icno)
    // {
    //     $count = self::find()
    //         ->where(['app_by' => $icno, 'status' => '2'])
    //         ->asArray()
    //         ->count('id');

    //     return $count;
    // }

    public static function totalVerifybsm($icno) // ketua bsm
    {
        // $verifier_bsm = Department::findOne(['=', 'id', '158']);
        // $kjbsm = $verifier_bsm->chief;
        $count = self::find()
                ->where(['verifybsm_by' => $icno,'status' =>'2'])
                // ->andWhere(['>=', 'entry_dt', '2022-06-15'])
                ->asArray()
                ->count('id');

                return $count;
    }

    public static function totalPendingApprovependaftar($icno) // pendaftar
    {

        $count = self::find()
                ->where(['app_by' => $icno,'status' =>'5'])
                ->asArray()
                ->count('id');

                return $count;
    }

    public static function totalPendingVerifybsm($icno) // perakuan ketua bsm
    {

        $count = self::find()
                ->where(['verifybsm_by' => $icno,'status' =>'2'])
                ->asArray()
                ->count('id');

                return $count;
    }
    
                   
}
