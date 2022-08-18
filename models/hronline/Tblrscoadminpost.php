<?php

namespace app\models\hronline;


use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\kehadiran\TblWp;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use app\models\hronline\Department;
use app\models\survey\TblAktiviti;

/**
 * This is the model class for table "tblrscoadminpost".
 *
 * @property int $id
 * @property string $ICNO
 * @property int $adminpos_id
 * @property int $jobStatus
 * @property int $paymentStatus
 * @property string $description
 * @property string $description_sef
 * @property int $dept_id
 * @property int $campus_id
 * @property string $appoinment_date
 * @property string $start_date
 * @property string $end_date
 * @property int $flag 0=waiting,1=active,2=not active
 * @property string $files
 * @property int $renew
 * @property int $status_tugas 1=Memangku,2=Menjalankan Tugas
 *
 * @property Adminposition $adminpos
 * @property Campus $campus
 * @property Department $dept
 * @property Flag $flag0
 * @property Jobstatus $jobStatus0
 * @property Paymentstatus $paymentStatus0
 * @property Renew $renew0
 */
class Tblrscoadminpost extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $file;
    public static function tableName()
    {
        return 'hronline.tblrscoadminpost';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'adminpos_id', 'description', 'jobStatus', 'paymentStatus', 'dept_id', 'campus_id', 'flag', 'appoinment_date', 'start_date', 'end_date'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            //            [['ICNO', 'adminpos_id', 'description', 'jobStatus', 'paymentStatus', 'dept_id', 'campus_id', 'flag', 'appoinment_date', 'start_date', 'end_date', 'reason', 'remark', 'letter_order_refno', 'date_letter_order'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['adminpos_id', 'program_id', 'jobStatus', 'paymentStatus', 'dept_id', 'campus_id', 'flag', 'renew', 'status_tugas'], 'integer'],
            [['appoinment_date', 'start_date', 'end_date', 'date_letter_order', 'penempatan_date', 'update_date'], 'safe'],
            [['ICNO', 'update_by'], 'string', 'max' => 12],
            [['description', 'description_sef', 'ulasan'], 'string', 'max' => 255],
            //            [['files'], 'string', 'max' => 300],
            [['adminpos_id'], 'exist', 'skipOnError' => true, 'targetClass' => Adminposition::className(), 'targetAttribute' => ['adminpos_id' => 'id']],
            [['program_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProgramPengajaran::className(), 'targetAttribute' => ['program_id' => 'id']],
            [['jawatantadbir_id'], 'exist', 'skipOnError' => true, 'targetClass' => JawatanPentadbiran::className(), 'targetAttribute' => ['jawatantadbir_id' => 'id']],
            [['campus_id'], 'exist', 'skipOnError' => true, 'targetClass' => Campus::className(), 'targetAttribute' => ['campus_id' => 'campus_id']],
            [['dept_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['dept_id' => 'id']],
            [['flag'], 'exist', 'skipOnError' => true, 'targetClass' => Flag::className(), 'targetAttribute' => ['flag' => 'flag_id']],
            [['jobStatus'], 'exist', 'skipOnError' => true, 'targetClass' => Jobstatus::className(), 'targetAttribute' => ['jobStatus' => 'jobstatus_id']],
            [['paymentStatus'], 'exist', 'skipOnError' => true, 'targetClass' => Paymentstatus::className(), 'targetAttribute' => ['paymentStatus' => 'paymentstatus_id']],
            [['renew'], 'exist', 'skipOnError' => true, 'targetClass' => Renew::className(), 'targetAttribute' => ['renew' => 'renew_id']],
            [['status_tugas'], 'exist', 'skipOnError' => true, 'targetClass' => Tugasstatus::className(), 'targetAttribute' => ['status_tugas' => 'tugasstatus_id']],

            [['reason'], 'integer'],
            [['remark'], 'string', 'max' => 200],
            [['letter_order_refno'], 'string', 'max' => 100],
            [['letter_refno'], 'string', 'max' => 30],

            [['file'], 'safe'],
            [['file'], 'file', 'extensions' => 'pdf'],
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
            'adminpos_id' => 'Adminpos ID',
            'program_id' => 'Program ID',
            'jawatantadbir_id' => 'Jawatan Tadbir ID',
            'jobStatus' => 'Job Status',
            'paymentStatus' => 'Payment Status',
            'description' => 'Description',
            'description_sef' => 'Description Sef',
            'dept_id' => 'Dept ID',
            'campus_id' => 'Campus ID',
            'appoinment_date' => 'Appoinment Date',
            'start_date' => 'Tarikh Mula',
            'end_date' => 'Tarikh Tamat',
            'flag' => 'Flag',
            'file' => 'File',
            'renew' => 'Renew',
            'status_tugas' => 'Status Tugas',
            'curWp' => 'WBB',
            'btnWp' => 'Update',
            'ulasan' => 'Ulasan'
        ];
    }

    public static function comparekj($dept, $type, $cat = null, $cat_id = null)
    {
        //  var_dump($type);die;

        // $val1 = "";
        $val3 = false;
        $val =  self::find()
        ->joinWith('adminpos')
        ->where(['dept_id' => $dept])->andWhere(['flag' => 1])->orderBy([
            'position_type' => SORT_ASC,

            'position_no' => SORT_ASC,
          ])->one();
        $val2 =  self::find()->where(['dept_id' => $dept])->andWhere(['flag' => 1])->andWhere(['adminpos_id' => 14])->one();
       
        if($val){
                    $val1 = $val->kakitangan->CONm;
        }
        else{
            $val1 = '';
        }
        //jabatan
            // if ($cat == 1) {

            //     if($dept == 8){

            //     }
            //     // $val1 =  self::find()->where(['dept_id' => $dept])->andWhere(['flag' => 1])->andWhere(['adminpos_id' => 5])->one();
            //     // if ($val1) {
            //     //     $val1 = $val1->kakitangan->CONm;
            //     // } else {
            //     //     $val1 = "";
            //     // }
            // }
        
        // else {
        //     if ($cat == 3) {
        //         $val1 =  self::find()->where(['dept_id' => $dept])->andWhere(['flag' => 1])->andWhere(['adminpos_id' => 3])->one();
        //         if ($val1) {
        //             $val1 = $val1->kakitangan->CONm;
        //         } else {
        //             $val1 = "";
        //         }
        //     }
        // }

        // if($cat == 2){
        //     $val3 =  self::find()->where(['dept_id' => $dept])->andWhere(['flag' => 1])->andWhere(['adminpos_id'=>3])->one();
        // }
        // // var_dump($val2);die;
        // if ($val) {
        //     $val1 = $val->kakitangan->CONm; 
        // }
        // elseif($val2){
        //     // $val =  self::find()->where(['dept_id' => $dept])->andWhere(['flag' => 1])->one();

        //     $val1 = $val2->kakitangan->CONm; 

        // }
        // elseif($val3){
        //     // $val =  self::find()->where(['dept_id' => $dept])->andWhere(['flag' => 1])->one();

        //     $val1 = $val3->kakitangan->CONm; 

        // }
        // else {
        //     // echo 'd';
        //     $val1 = "";
        // }
        return $val1;
    }
    public static function comparepp($dept, $type)
    {

        $val =  self::find()->where(['dept_id' => $dept])->andWhere(['flag' => 1])->andWhere(['adminpos_id' => $type])->one();
        $val2 =  self::find()->where(['dept_id' => $dept])->andWhere(['flag' => 1])->one();
        // var_dump($dept,$type);die;
        if ($val) {
            $val1 = $val->kakitangan->CONm;
        }
        // elseif($val2){
        //     // $val =  self::find()->where(['dept_id' => $dept])->andWhere(['flag' => 1])->one();

        //     $val1 = $val2->kakitangan->CONm; 

        // }
        else {
            $val1 = "";
        }
        return $val1;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKakitangan()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdminpos()
    {
        return $this->hasOne(Adminposition::className(), ['id' => 'adminpos_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgram()
    {
        return $this->hasOne(ProgramPengajaran::className(), ['id' => 'program_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJawatantadbir()
    {
        return $this->hasOne(JawatanPentadbiran::className(), ['id' => 'jawatantadbir_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampus()
    {
        return $this->hasOne(Campus::className(), ['campus_id' => 'campus_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDept()
    {
        return $this->hasOne(Department::className(), ['id' => 'dept_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlag0()
    {
        return $this->hasOne(Flag::className(), ['flag_id' => 'flag']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobStatus0()
    {
        return $this->hasOne(Jobstatus::className(), ['jobstatus_id' => 'jobStatus']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentStatus0()
    {
        return $this->hasOne(Paymentstatus::className(), ['paymentstatus_id' => 'paymentStatus']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRenew0()
    {
        return $this->hasOne(Renew::className(), ['renew_id' => 'renew']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTugasStatus0()
    {
        return $this->hasOne(Tugasstatus::className(), ['tugasstatus_id' => 'status_tugas']);
    }

    public function getSebabPenempatan0()
    {
        return $this->hasOne(RefReasonPenempatan::className(), ['reason_id' => 'reason']);
    }

    public function getCurWp()
    {
        $label = TblWp::curr_wp($this->ICNO, true);

        if ($label == 'WBFA') {
            return "<span class='label label-danger'>$label</span>";
        } else if ($label == 'WBF') {
            return "<span class='label label-success'>$label</span>";
        } else {
            return "<span class='label label-warning'>$label</span>";
        }
    }

    public function getBtnWp()
    {
        return Html::a('<i class="fa fa-pencil"></i>', ['kehadiran/wbb-list', 'id' => $this->ICNO], ['class' => 'btn btn-default btn-sm', 'target' => '_blank']);
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

        return date_format(date_create($bulan), "d") . ' ' . $m . ' ' . date_format(date_create($bulan), "Y");
    }

    public function getTarikhmula()
    {
        if ($this->start_date != '') {
            return $this->getTarikh($this->start_date);
        }
    }
    //        public function getTarikhmula() {
    //        return  $this->getTarikh($this->start_date);
    //    }

    public function getTarikhtamat()
    {
        if ($this->end_date != '') {
            return $this->getTarikh($this->end_date);
        }
    }

    //        public function getTarikhtamat() {
    //        return  $this->getTarikh($this->end_date);
    //    }

    public function getTarikhkuatkuasa()
    {
        if ($this->appoinment_date != '') {
            return $this->getTarikh($this->appoinment_date);
        }
    }

    public function getTarikhletterorder()
    {
        if ($this->date_letter_order != '') {
            return $this->getTarikh($this->date_letter_order);
        }
    }

    public function getTarikhmulapenempatan()
    {
        if ($this->penempatan_date != '') {
            return $this->getTarikh($this->penempatan_date);
        }
    }

    //        public function getTarikhkuatkuasa() {
    //        return  $this->getTarikh($this->appoinment_date);
    //    }

    public function getDisplayjobstatus()
    {
        return $this->hasOne(Jobstatus::className(), ['jobstatus_id' => 'jobStatus']);
    }

    public function getDisplaypaymentstatus()
    {
        return $this->hasOne(Paymentstatus::className(), ['paymentstatus_id' => 'paymentStatus']);
    }

    public function getDisplayrenew()
    {
        return $this->hasOne(Renew::className(), ['renew_id' => 'renew']);
    }

    public function getDisplaydepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'dept_id']);
    }

    public function getDisplaycampus()
    {
        return $this->hasOne(Campus::className(), ['campus_id' => 'campus_id']);
    }

    public function getDisplayflag()
    {
        return $this->hasOne(Flag::className(), ['flag_id' => 'flag']);
    }

    public function getDisplayflagstatuslantikansemula()
    {
        if ($this->renew == '0') {
            return '<span class="label label-primary">Menunggu</span>';
        } elseif ($this->renew == '1') {
            return '<span class="label label-success">Dilantik Semula</span>';
        }
    }

    public function getDisplayadminpos()
    {
        return $this->hasOne(Adminposition::className(), ['id' => 'adminpos_id']);
    }

    public function getDisplayjawatantadbir()
    {
        return $this->hasOne(JawatanPentadbiran::className(), ['id' => 'jawatantadbir_id']);
    }

    public function getDisplaytugasstatus()
    {
        return $this->hasOne(Tugasstatus::className(), ['tugasstatus_id' => 'status_tugas']);
    }

    public function getBaki()
    {
        $m = Tblrscoadminpost::find()->where(['ICNO' => $this->ICNO])->andWhere(['flag' => '1'])->max('end_date');
        $date1 = date_create($m);
        $date2 = date_create(date('Y-m-d'));
        $tempoh = date_diff($date1, $date2)->format('%a Hari');

        return $tempoh;
    }

    public function getTempoh()
    {
        $date1 = date_create($this->start_date);
        $date2 = date_create($this->end_date);
        return date_diff($date1, $date2)->format('%y Year, %m Month, %d Day');
    }

    public function getTempohBM()
    {
        $date1 = date_create($this->start_date);
        $date2 = date_create($this->end_date);
        return date_diff($date1, $date2)->format('%y Tahun, %m Bulan, %d Hari');
    }

    public function getTempohType($type)
    {
        $date1 = date_create($this->start_date);
        $date2 = date_create($this->end_date);
        return date_diff($date1, $date2)->format($type);
    }

    //log for Create, update or delete data.
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $changes = [];
        $tempObj = self::findOne(['id' => $this->id]);
        $attrib = $this->activeAttributes();

        switch ($insert) {
            case (false):
                $activity = 1;
                for ($i = 0; $i < count($attrib); $i++) {

                    if ($tempObj->{$attrib[$i]} != $this->{$attrib[$i]}) {
                        array_push($changes, [$attrib[$i], $tempObj->{$attrib[$i]}, $this->{$attrib[$i]}]);
                    }
                }

                break;

            default:
                //aftersave will handle it
                break;
        }
        if (count($changes) > 0) {
            //log activity to updatestatus table
            $log = new Updatestatus();
            $log->usern = $tempObj->ICNO; //Yii::$app->user->getId();
            $log->COTableName = $this->tableName();
            $log->COActivity = $activity;
            $log->COUpadteDate = date('Y-m-d H:i:s');
            if (Yii::$app->user->getId()) {
                $log->COUpdateIP = Yii::$app->request->getRemoteIP();
                $log->COUpdateComp = Yii::$app->request->getRemoteIP();
            } else {
                $log->COUpdateIP = Yii::$app->controller->id;
                $log->COUpdateComp = Yii::$app->controller->id;
            }
            $log->COUpdateCompUser = Yii::$app->user->getId() ? Yii::$app->user->getId() : Yii::$app->controller->id;
            $log->COUpdateSQL = serialize($changes);
            $log->idval = $this->id;
            $log->save(false);

            //save to tbl_stat
            $stat = Tblstat::find()->where(['ICNO' => $this->ICNO, 'table' => $this->tableName(), 'idval' => $this->id])->one();
            if ($stat == null) {
                $stat = new Tblstat();
                $stat->ICNO = $this->ICNO;
                $stat->table = $this->tableName();
                $stat->idval = $this->id;
            }
            $stat->status = 1;
            $stat->date_submit = date('Y-m-d H:i:s');
            $stat->save(false);
        }

        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            //save to tbl_stat
            $stat = new Tblstat();
            $stat->ICNO = $this->ICNO;
            $stat->table = $this->tableName();
            $stat->idval = $this->id;
            $stat->status = 0;
            $stat->date_submit = date('Y-m-d H:i:s');
            $stat->save(false);

            $changes = [];
            //$tempObj = self::findOne(['id' => $this->id]);
            $attrib = $this->activeAttributes();
            $activity = 0;

            for ($i = 0; $i < count($attrib); $i++) {
                array_push($changes, [$attrib[$i], $this->{$attrib[$i]}]);
            }

            $log = new Updatestatus();
            $log->usern = $this->ICNO; //Yii::$app->user->getId();
            $log->COTableName = $this->tableName();
            $log->COActivity = $activity;
            $log->COUpadteDate = date('Y-m-d H:i:s');
            if (Yii::$app->user->getId()) {
                $log->COUpdateIP = Yii::$app->request->getRemoteIP();
                $log->COUpdateComp = Yii::$app->request->getRemoteIP();
            } else {
                $log->COUpdateIP = Yii::$app->controller->id;
                $log->COUpdateComp = Yii::$app->controller->id;
            }
            $log->COUpdateCompUser = Yii::$app->user->getId() ? Yii::$app->user->getId() : Yii::$app->controller->id;
            $log->COUpdateSQL = serialize($changes);
            $log->idval = $this->id;
            $log->save(false);
        }

        return true;
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        $changes = [];

        //get list of attributes
        $attrib = $this->activeAttributes();

        for ($i = 0; $i < count($attrib); $i++) {
            array_push($changes, array($attrib[$i], $this->{$attrib[$i]}));
        }
        //log activity to updatestatus table
        $log = new Updatestatus();
        $log->usern = $this->ICNO;
        $log->COTableName = $this->tableName();
        $log->COActivity = 2;
        $log->COUpadteDate = date('Y-m-d H:i:s');
        if (Yii::$app->user->getId()) {
            $log->COUpdateIP = Yii::$app->request->getRemoteIP();
            $log->COUpdateComp = Yii::$app->request->getRemoteIP();
        } else {
            $log->COUpdateIP = Yii::$app->controller->id;
            $log->COUpdateComp = Yii::$app->controller->id;
        }
        $log->COUpdateCompUser = Yii::$app->user->getId() ? Yii::$app->user->getId() : Yii::$app->controller->id;
        $log->COUpdateSQL = serialize($changes);
        $log->save(false);
        $stat = Tblstat::find()->where(['ICNO' => $this->ICNO, 'table' => $this->tableName(), 'idval' => $this->id])->one();
        if ($stat == null)
            return true;

        $stat->delete();

        return true;
    }

    public function getAktivitiId()
    {

        $aktiviti = TblAktiviti::find()->where(['tamat_id' => $this->id])->one();

        if ($aktiviti) {
            return $aktiviti->id;
        }

        return null;
    }
}
