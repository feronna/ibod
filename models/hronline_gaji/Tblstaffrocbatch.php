<?php

namespace app\models\hronline_gaji;

use app\models\gaji\TblKumpulan;
use app\models\hronline\JadualGaji;
use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\gredJawatan;

/**
 * This is the model class for table "hronline_gaji.staff_roc_batch".
 *
 * @property string $srb_cmpy_code
 * @property string $srb_batch_code
 * @property string $srb_staff_id
 * @property string $srb_change_reason
 * @property string $srb_remarks
 * @property string $srb_status
 * @property string $srb_process_dept
 * @property string $srb_enter_by
 * @property string $srb_enter_date
 * @property string $srb_verify_by
 * @property string $srb_verify_date
 * @property string $srb_approve_by
 * @property string $srb_approve_date
 * @property string $srb_cancel_by
 * @property string $srb_cancel_date
 * @property string $SRB_SOURCE
 * @property string $srb_effective_date
 * @property string $srb_dept_code
 * @property string $srb_job_code
 */
class Tblstaffrocbatch extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'hrm.gaji_staff_roc_batch';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['srb_cmpy_code', 'srb_batch_code', 'srb_staff_id', 'srb_change_reason'], 'required'],
            [['srb_remarks'], 'string'],
            [['srb_enter_date', 'srb_verify_date', 'srb_approve_date', 'srb_cancel_date'], 'safe'],
            [['srb_cmpy_code', 'srb_status', 'srb_process_dept', 'srb_effective_date', 'srb_dept_code', 'srb_job_code'], 'string', 'max' => 10],
            [['srb_batch_code'], 'string', 'max' => 50],
            [['srb_staff_id', 'srb_change_reason', 'srb_enter_by', 'srb_verify_by', 'srb_approve_by', 'srb_cancel_by', 'SRB_SOURCE'], 'string', 'max' => 30],
            [['srb_batch_code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'srb_cmpy_code' => 'Srb Cmpy Code',
            'srb_batch_code' => 'Srb Batch Code',
            'srb_staff_id' => 'Srb Staff ID',
            'srb_change_reason' => 'Srb Change Reason',
            'srb_remarks' => 'Srb Remarks',
            'srb_status' => 'Srb Status',
            'srb_process_dept' => 'Srb Process Dept',
            'srb_enter_by' => 'Srb Enter By',
            'srb_enter_date' => 'Srb Enter Date',
            'srb_verify_by' => 'Srb Verify By',
            'srb_verify_date' => 'Srb Verify Date',
            'srb_approve_by' => 'Srb Approve By',
            'srb_approve_date' => 'Srb Approve Date',
            'srb_cancel_by' => 'Srb Cancel By',
            'srb_cancel_date' => 'Srb Cancel Date',
            'SRB_SOURCE' => 'Srb Source',
            'srb_effective_date' => 'Srb Effective Date',
            'srb_dept_code' => 'Srb Dept Code',
            'srb_job_code' => 'Srb Job Code',
        ];
    }

    public function getStaffRoc() {
        return $this->hasMany(Tblstaffroc::className(), ['SR_ENTRY_BATCH' => 'srb_batch_code']);
    }
    
    public function getSumOld() {
        return $this->hasMany(Tblstaffroc::className(), ['SR_ENTRY_BATCH' => 'srb_batch_code'])->sum('SR_OLD_VALUE');
    }
    
    public function getSumNew() {
        return $this->hasMany(Tblstaffroc::className(), ['SR_ENTRY_BATCH' => 'srb_batch_code'])->sum('SR_NEW_VALUE');
    }
    
    public function getReason() {
        return $this->hasOne(roc_reason::className(), ['RR_REASON_CODE' => 'srb_change_reason']);
    }
    
    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['COOldID' => 'srb_approve_by']);
    }
    
    public function getDepartment() {
        return $this->hasOne(Department::className(), ['dm_dept_code' => 'srb_dept_code']);
    }
    
    public function getBiodataSendiri() {
        return $this->hasOne(Tblprcobiodata::className(), ['COOldID' => 'srb_staff_id']);
    }
    
    public function getStaffRoc2() {
        return $this->hasMany(TblStaffRoc::className(), ['SR_ENTRY_BATCH' => 'srb_batch_code'])->orderBy(['SR_ROC_TYPE'=>SORT_ASC]);
    }

    public function getProcessDept() {
        return $this->hasOne(DepartmentMain::className(), ['dm_dept_code' => 'srb_process_dept']);
    }

    public function getJadualGaji() {
        return $this->hasOne(JadualGaji::className(), ['r_jg_gred' => 'srb_job_code']);
    }

    public function getGredJawatan(){
        return $this->hasOne(gredJawatan::className(), ['id' => 'srb_job_code']);
    }

    public static function Tasks($icno, $role){
        $lpg_allowed = TblKumpulan::lpgListByRole($icno, $role, true);
        switch ($role) {
            case 'ENTRY':
                $total_tasks = self::find()->where(['IN','srb_change_reason',$lpg_allowed])->andWhere(['srb_status'=>'ENTRY'])->count();
                break;
            case 'VERIFY':
                $total_tasks = self::find()->where(['IN','srb_change_reason',$lpg_allowed])->andWhere(['srb_status'=>'APPLY'])->count();
                break;
            case 'APPROVE':
                $total_tasks = self::find()->where(['IN','srb_change_reason',$lpg_allowed])->andWhere(['srb_status'=>'VERIFY'])->count();
                break;
            
            default:
                $total_tasks = -1;
                break;
        }
        return $total_tasks;
       
    }

    

    
}
