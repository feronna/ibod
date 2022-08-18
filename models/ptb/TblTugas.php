<?php

namespace app\models\ptb;
use app\models\hronline\Department;
use Yii;

/**
 * This is the model class for table "ptb.tbl_tugas".
 *
 * @property int $id
 * @property int $application_id
 * @property string $icno
 * @property string $pemohon_name
 * @property string $catatan_pengganti
 * @property string $nama_pengganti
 * @property string $bioadata_ICNO
 * @property string $pengganti_ICNO
 * @property string $nama_ketua
 * @property string $catatan_individu
 * @property string $update
 * @property string $nota_sent
 * @property string $tarikh_individu_hantar
 * @property int $old_dept
 */
class TblTugas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.ptb_tbl_tugas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['application_id', 'old_dept'], 'integer'],
            [['icno', 'pemohon_name'], 'string', 'max' => 50],
            [['catatan_pengganti', 'nama_pengganti'], 'string', 'max' => 100],
            [['pengganti_ICNO'], 'string', 'max' => 20],
            [['catatan_individu', 'tarikh_individu_hantar'], 'string', 'max' => 255],
            [['update'], 'string', 'max' => 155],
            [['nota_sent'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'application_id' => 'Application ID',
            'icno' => 'Icno',
            'pemohon_name' => 'Pemohon Name',
            'catatan_pengganti' => 'Catatan Pengganti',
            'nama_pengganti' => 'Nama Pengganti',
         
            'pengganti_ICNO' => 'Pengganti Icno',
            
            'catatan_individu' => 'Catatan Individu',
            'update' => 'Update',
            'nota_sent' => 'Nota Sent',
            'tarikh_individu_hantar' => 'Tarikh Individu Hantar',
            'old_dept' => 'Old Dept',
        ];
    }
     public function getSerahTugas(){
        return $this->hasOne(TblSerahTugas::className(), ['tugas_id' => 'id']);
    }
      public function getTarikh($bulan){
        
        $m = date_format(date_create($bulan), "m");
        if($m == 01){
            $m = "Januari";}
        elseif ($m == 02){
          $m = "Februari";}
        elseif ($m == 03){
          $m = "Mac";}
        elseif ($m == 04){
          $m = "April";}
        elseif ($m == 05){
          $m = "Mei";}
        elseif ($m == 06){
          $m = "Jun";}
        elseif ($m == 07){
          $m = "Julai";}
        elseif ($m == '08'){
          $m = "Ogos";}
        elseif ($m == '09'){
          $m = "September";}
        elseif ($m == '10'){
          $m = "Oktober";}
        elseif ($m == '11'){
          $m = "November";}
        elseif ($m == '12'){
          $m = "Disember";}
          
        return date_format(date_create($bulan), "d").' '.$m.' '.date_format(date_create($bulan), "Y H:i:s A");
    }
    public function getUpdates() {
        return  $this->getTarikh($this->update);
    }
        public function getTarikhIndividuHantar() {
        return  $this->getTarikh($this->tarikh_individu_hantar);
    }
     public function getOldDepartment(){
        return $this->hasOne(Department::className(), ['id' => 'old_dept']);
    }
    public function getApplicant(){
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    public function getApplication(){
        return $this->hasOne(Application::className(), ['id' => 'application_id']);
    }
    public function getApp(){
        return $this->hasOne(Application::className(), ['id' => 'application_id']);
    }
    public static function totalPendings() {
        $jabatan = Department::findOne(['chief' => Yii::$app->user->getId()]);
        $app = TblTugas::find()->where(['old_dept' => $jabatan->id])->all();
        $total = 0;
        $model = TblTugas::find()->where(['icno' => $app, 'pengganti_ICNO' => null, 'nota_sent' => 1])->all();
        
        if ($model) {
            $total = count($model);
        }
        if ($total > 0) {
                return '&nbsp;<span class="badge bg-red">' . $total . '</span>';
            }
        else {
                return '';
        }
    }
    public static function totalPendingIndividu() {
        $icno = Yii::$app->user->getId();
        $total = 0;
        $model = TblTugas::find()->where(['nota_sent' => 0, 'icno' => $icno])->all();
        
        if ($model) {
            $total = count($model);
        }
        if ($total > 0) {
                return '&nbsp;<span class="badge bg-red">' . $total . '</span>';
            }
        else {
                return '';
        }
    }
}
