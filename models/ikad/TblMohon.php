<?php

namespace app\models\ikad;

use app\models\hronline\GredJawatan;
use app\models\hronline\PendidikanTertinggi;
use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "ikad.tbl_mohon".
 *
 * @property int $id
 * @property string $applier_id
 * @property int $language_id 0=MIX,1=BM,2=BI
 * @property string $title_bm
 * @property string $title_bi
 * @property string $d_nama
 * @property string $d_edu_bi_1
 * @property string $d_edu_bi_2
 * @property string $d_edu_bm_1
 * @property string $d_edu_bm_2
 * @property string $d_jawatan_bi
 * @property string $d_jawatan_bm
 * @property string $d_jbtn_bi
 * @property string $d_jbtn_bm
 * @property string $d_kampus_bi
 * @property string $d_kampus_bm
 * @property string $d_kampus2_bi
 * @property string $d_kampus2_bm
 * @property string $d_office_telno
 * @property string $d_office_extno
 * @property string $d_faxno
 * @property string $d_hpno
 * @property string $d_email
 * @property int $d_pieces 1=100,2=200,3=300
 * @property string $d_tarikh_mohon
 * @property string $d_hantar
 * @property string $d_tarikh_hantar
 * @property int $d_status_kad 0=Baru,1=Proses,2=Siap,3=Selesai/Telah Diambil
 * @property string $d_status_tarikh
 * @property string $d_update_id
 * @property string $d_peraku_peg
 * @property string $d_peraku_peg_id
 * @property string $d_peraku_peg_dt
 */
class TblMohon extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.ikad_tbl_mohon';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['language_id', 'd_pieces', 'status_kad', 'd_peraku_peg','hantar_status','gred_jawatan'], 'integer'],
            [['d_tarikh_mohon', 'd_tarikh_hantar', 'd_status_tarikh', 'd_peraku_peg_dt'], 'safe'],
            [['remark'], 'string'],
            [['dept_address_bi_1','dept_address_bi_2','dept_address_bm_1','dept_address_bm_2'], 'string', 'max' => 250],
            [['applier_id', 'd_update_id', 'd_peraku_peg_id'], 'string', 'max' => 12],
            [['title_bm', 'title_bi', 'd_edu_bi_1', 'd_edu_bi_2', 'd_edu_bm_1', 'd_edu_bm_2', 'd_jawatan_bi', 'd_jawatan_bm', 'd_email'], 'string', 'max' => 100],
            [['d_nama', 'd_jbtn_bi', 'd_jbtn_bm', 'd_kampus_bi', 'd_kampus_bm', 'd_kampus2_bi', 'd_kampus2_bm'], 'string', 'max' => 255],
            [['d_office_telno', 'd_office_extno', 'd_faxno', 'd_hpno'], 'string', 'max' => 30],

            //admin
            [['checked_by','approved_by'], 'string','max'=>12],
            [['app_status'], 'string','max'=>9],
            [['checked_dt','approved_dt'], 'safe'],
            // [['d_nama', 'dept_address_bi_1', 'dept_address_bm_1','d_jbtn_bi','d_jbtn_bm'], 'required', 'message' => 'Please Complete This'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'applier_id' => 'Applier ID',
            'language_id' => 'Language ID',
            'title_bm' => 'Title Bm',
            'title_bi' => 'Title Bi',
            'd_nama' => 'D Nama',
            'd_edu_bi_1' => 'D Edu Bi 1',
            'd_edu_bi_2' => 'D Edu Bi 2',
            'd_edu_bm_1' => 'D Edu Bm 1',
            'd_edu_bm_2' => 'D Edu Bm 2',
            'd_jawatan_bi' => 'D Jawatan Bi',
            'd_jawatan_bm' => 'D Jawatan Bm',
            'd_jbtn_bi' => 'D Jbtn Bi',
            'd_jbtn_bm' => 'D Jbtn Bm',
            'd_kampus_bi' => 'D Kampus Bi',
            'd_kampus_bm' => 'D Kampus Bm',
            'd_kampus2_bi' => 'D Kampus2 Bi',
            'd_kampus2_bm' => 'D Kampus2 Bm',
            'd_office_telno' => 'D Office Telno',
            'd_office_extno' => 'D Office Extno',
            'd_faxno' => 'D Faxno',
            'd_hpno' => 'D Hpno',
            'd_email' => 'D Email',
            'd_pieces' => 'D Pieces',
            'd_tarikh_mohon' => 'D Tarikh Mohon',
            'd_hantar' => 'D Hantar',
            'd_tarikh_hantar' => 'D Tarikh Hantar',
            'd_status_kad' => 'D Status Kad',
            'd_status_tarikh' => 'D Status Tarikh',
            'd_update_id' => 'D Update ID',
            'd_peraku_peg' => 'D Peraku Peg',
            'd_peraku_peg_id' => 'D Peraku Peg ID',
            'd_peraku_peg_dt' => 'D Peraku Peg Dt',
        ];
    }

    public function getName()
    {

        $val = '';
        $icno = Yii::$app->user->getId();
        $name = Tblprcobiodata::findOne(['ICNO'=>$icno]);
    
        return $name->CONm;
    }
    public function getCheck()
    {

        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'checked_by']);

    }
    public function getApproved()
    {

        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'approved_by']);

    }
    public function getCardlang()
    {
        $lang = "";

        if ($this->language_id == '0') {
            $lang = 'Both (English & Malay)';
        }
        if ($this->language_id == '1') {
            $lang = 'English';
        }
        if ($this->language_id == '2') {
            $lang = 'Malay';
        }

        return $lang;
    }
    public function getAppStatus()
    {
        $lang = "";

        if ($this->status_kad == '0') {
            $lang = 'New';
        }else
        if ($this->status_kad == '1') {
            $lang = 'In Process';
        }else
        if ($this->status_kad == '2') {
            $lang = 'Ready to Take';
        }else
        if ($this->status_kad == '6') {
            $lang = 'Rejected';
        }else
        if ($this->status_kad == '3') {

            $lang1 = 'Waiting To be Submitted by Applicant';
            $lang = '<span class="badge bg-red">' . $lang1 . '</span>';

        }else
        if ($this->status_kad == '4') {

            $lang = 'Completed';

        }else{
            $lang = 'In Process';
        }

        return $lang;
    }
   
    public function changeDateFormat($date)
    {

        $dt = date_create($date);

        $v = date_format($dt, "d/m/Y");

        return $v;
    }

    public function getFormatTarikh()
    {

        return $this->changeDateFormat($this->d_tarikh_mohon);
    }

    public function getKakitangan()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'applier_id']);
    }
    public function getGred()
    {
   
        return $this->hasOne(GredJawatan::className(), ['id' => 'gred_jawatan']);
    }
    
    public function getHighestedu()
    {
        $model = PendidikanTertinggi::findOne(['HighestEduLevelCd'=>$this->kakitangan->HighestEduLevelCd]);
        
        return $model->HighestEduLevel;
        // Tblprcobiodata::find()->where([''])->one();

    }
    public function getAddress()
    {
        // $model = self::findOne(['id'=>'id']);
        if($this->dept_address_bi_1){
            $mod = $this->dept_address_bi_1.' ' . $this->dept_address_bi_2;
        }else{
            $mod = $this->dept_address_bm_1.' ' . $this->dept_address_bm_2;

        }
        
        // Tblprcobiodata::find()->where([''])->one();
        return $mod;
    }
    public function getAdminAppStatus()
    {
        $lang = "";

        
        if ($this->status_kad == '1') {
            $lang = 'New';
        }
        if ($this->status_kad == '2') {
            $lang = 'Ready to Take';
        }
        if ($this->status_kad == '4') {

            $lang = 'Completed';

        }
        if ($this->status_kad == '5') {

            $lang = 'Sent To Vendor';

        }
        if ($this->status_kad == '6') {

            $lang = 'Rejected';

        }
        if ($this->status_kad == '7') {

            $lang = 'Checked';

        }
        if ($this->status_kad == '8') {

            $lang = 'Approved';

        }

        return $lang;
    }
    //pending task
    public static function totalPendingApproval($icno)
    {
        // $count = Yii::$app->cache->get('total-pending-approval-'.$icno);
        // if(!$count){
        $count = self::find()
            ->where(['approved_by' => $icno, 'status_kad' => '7'])
            // ->andWhere(['YEAR(start_date)'=>date('Y')])
            ->asArray()
            ->count('id');
        // Yii::$app->cache->set('total-pending-approval-'.$icno, $count);
        // }

        return $count;
    }
    public static function totalPendingCheck($icno)
    {
        // $count = Yii::$app->cache->get('total-pending-approval-'.$icno);
        // if(!$count){
        $count = self::find()
            ->where(['checked_by' => $icno])
            ->andWhere([ 'IN','status_kad' ,['1']])
            ->asArray()
            ->count('id');
        // Yii::$app->cache->set('total-pending-approval-'.$icno, $count);
        // }

        return $count;
    }

}
