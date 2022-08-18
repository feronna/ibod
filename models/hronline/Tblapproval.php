<?php

namespace app\models\hronline;

use Yii;
use app\models\hronline\RTable;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;

/**
 * This is the model class for table "hronline.tblapproval".
 *
 * @property int $id
 * @property string $ICNO usern
 * @property string $table table name of datas
 * @property string $idval id ref to table of datas
 * @property string $date_submit
 * @property int $activity 0=new;1=update;3=delete
 * @property string $dataSQL
 * @property string $approval_by icno of approver/rejector
 * @property string $approval_date
 * @property int $approval_status 0=pending;1=approved;2=rejected
 */
class Tblapproval extends \yii\db\ActiveRecord
{   public $deptid = '';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.tblapproval';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO'], 'required'],
            [['activity', 'approval_status'], 'integer'],
            [['date_submit', 'approval_date'], 'safe'],
            [['dataSQL'], 'string'],
            [['ICNO', 'idval', 'approval_by'], 'string', 'max' => 12],
            [['table'], 'string', 'max' => 50],
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
            'table' => 'Table',
            'idval' => 'Idval',
            'date_submit' => 'Date Submit',
            'activity' => 'Activity',
            'dataSQL' => 'Data Sql',
            'approval_by' => 'Approval By',
            'approval_date' => 'Approval Date',
            'approval_status' => 'Approval Status',
        ];
    }

    public function getNamaBahagian()
    {
        return $this->hasOne(RTable::className(), ['db_table' => 'table']);
    }

    public function getNamaPengemaskini()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'approval_by']);
    }

    public function getBiodata(){
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }

    public function getDept_pp(){
        if($this->biodata){
            $this->deptid = $this->biodata->DeptId;
        }else{
            return false;
        }

        $department = Department::findOne(['id'=>$this->deptid]);
        if(is_null($department->sub_of)){
            return $department->pp;
        }

        $department = Department::findOne(['id'=>$department->sub_of]);
        if($department->pp){
            return $department->pp;
        }
        return $department->chief;
    }

    public function getIsAdminOrPp(){
        $permission = false;
        $icno = Yii::$app->user->getId();
        switch (Yii::$app->user->identity->accessLevel) {
            case '1':
                $permission = true;
                break;
            case '2':
                if (['IN', Yii::$app->user->identity->accessSecondLevel, ['1', '3']]) {
                    $permission = true;
                }
                break;

            default:
                if($icno == $this->dept_pp){
                    $permission = true;
                }
                break;
        }

        return $permission;
    }

    public function getNama_bahagian()
    {
        if ($this->namaBahagian) {
            return $this->namaBahagian->nama;
        }
        return "Table Name not found.";
    }

    public function getAktiviti()
    {
        switch ($this->activity) {
            case '1':
                return 'Kemaskini';
                break;
            case '2':
                return 'Buang';
                break;

            default:
                return 'Baru';
                break;
        }
    }

    public function getTarikhHantar()
    {
        return  $this->getTarikh($this->date_submit);
    }

    public function getStatus()
    {
        switch ($this->approval_status) {
            case '1':
                return '<span class="btn-sm btn-success">Disahkan</span>';
                break;

            default:
                return '<span class="btn-sm btn-danger">Ditolak</span>';
                break;
        }
    }

    public function getTarikh($bulan)
    {

        $m = date_format(date_create($bulan), "m");
        if ($m == 01) {
            $m = "Januari";
        } elseif ($m == 02) {
            $m = "Februari";
        } elseif ($m == 03) {
            $m = "Mac";
        } elseif ($m == 04) {
            $m = "April";
        } elseif ($m == 05) {
            $m = "Mei";
        } elseif ($m == 06) {
            $m = "Jun";
        } elseif ($m == 07) {
            $m = "Julai";
        } elseif ($m == '08') {
            $m = "Ogos";
        } elseif ($m == '09') {
            $m = "September";
        } elseif ($m == '10') {
            $m = "Oktober";
        } elseif ($m == '11') {
            $m = "November";
        } elseif ($m == '12') {
            $m = "Disember";
        }

        return date_format(date_create($bulan), "d") . ' ' . $m . ' ' . date_format(date_create($bulan), "Y H:i:s A");
    }
}
