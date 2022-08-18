<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "{{%myidp.tbl_sirilatihanjfpiu}}".
 *
 * @property int $kursusLatihanID
 * @property int $siriLatihanID
 * @property string $siri
 * @property string $lokasi
 * @property string $tarikhMula
 * @property string $tarikhAkhir
 * @property string $masaMula
 * @property int $jumlahJamLatihan
 * @property int $jumlahMataIDP
 * @property string $statusSiriLatihan
 * @property string $filename
 * @property int $kuota
 * @property int $kampusID
 */
class SiriLatihanJfpiu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    
    public $file;
    
    public static function tableName()
    {
        return '{{%myidp.tbl_sirilatihanjfpiu}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kursusLatihanID', 'jumlahJamLatihan', 'jumlahMataIDP', 'kuota', 'kampusID'], 'integer'],
            [['tarikhMula', 'tarikhAkhir', 'masaMula', 'masaTamat'], 'safe'],
            [['siri', 'statusSiriLatihan'], 'string', 'max' => 25],
            [['lokasi', 'filename'], 'string', 'max' => 100],
            [['file'], 'file','extensions'=>'pdf, png, jpg', 'maxFiles' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kursusLatihanID' => 'Kursus Latihan ID',
            'siriLatihanID' => 'Siri Latihan ID',
            'siri' => 'Siri',
            'lokasi' => 'Lokasi',
            'tarikhMula' => 'Tarikh Mula',
            'tarikhAkhir' => 'Tarikh Akhir',
            'masaMula' => 'Masa Mula',
            'masaTamat' => 'Masa Tamat',
            'jumlahJamLatihan' => 'Jumlah Jam Latihan',
            'jumlahMataIDP' => 'Jumlah Mata Idp',
            'statusSiriLatihan' => 'Status Siri Latihan',
            'filename' => 'Filename',
            'kuota' => 'Kuota',
            'kampusID' => 'Kampus ID',
        ];
    }
    
    /** Relation **/
    public function getSasaran3(){
        //return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id'=>'iid']);
        return $this->hasOne(KursusLatihanJfpiu::className(), ['kursusLatihanID' => 'kursusLatihanID']);
    }
    
    public function getSiriAmount($id)
    {
        $count = $this::find()
            ->where(['kursusLatihanID' => $id])
            ->count();
        
        return $count;
    }
    
    /** Relation **/
    public function getSasaran5(){
        //return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id'=>'iid']);
        return $this->hasOne(SlotLatihanJfpiu::className(), ['siriLatihanID' => 'siriLatihanID']);
    }
    
    public function getSasaran7(){
        //return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id'=>'iid']);
        return $this->hasMany(SiriLatihanBahan::className(), ['siriLatihanID' => 'siriLatihanID']);
    }
    
    /** Relation **/
    public function getCeramah(){
        //return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id'=>'iid']);
        return $this->hasMany(Ceramah::className(), ['siriLatihanID' => 'siriLatihanID']);
    }
    
    public function getTarikhKursus2(){
        
        $dayyDateTime = \DateTime::createFromFormat('Y-m-d', $this->tarikhMula);
        $formatteddate = $dayyDateTime->format('d-m-Y');
        //$hariMula = substr($formatteddate,0,8).''.'20';
        
        $dayyDateTime2 = \DateTime::createFromFormat('Y-m-d', $this->tarikhAkhir);
        $formatteddate2 = $dayyDateTime2->format('d-m-Y');
        //$hariAkhir = substr($formatteddate2,0,8).''.'20';
        
        if ($formatteddate == $formatteddate2 ){
            
            return $formatteddate;    
        } else {

            return $formatteddate.' - '.$formatteddate2;
        }
    }
    
    public function getTarikhKursus(){
        
        $dayyDateTime = \DateTime::createFromFormat('Y-m-d', $this->tarikhMula);
        $formatteddate = $dayyDateTime->format('d-m-Y');
        $hariMula = substr($formatteddate,0,8).''.'20';
        
        $dayyDateTime2 = \DateTime::createFromFormat('Y-m-d', $this->tarikhAkhir);
        $formatteddate2 = $dayyDateTime2->format('d-m-Y');
        $hariAkhir = substr($formatteddate2,0,8).''.'20';
        
        if ($hariMula == $hariAkhir ){
            
            return $hariMula;    
        } else {

            return $hariMula.' - '.$hariAkhir;
        }
    }
    
    public function getLokasiKursus(){
        
        if ($this->lokasi != NULL){
            return $this->lokasi;
        } else {
            return "AKAN DIMAKLUMKAN KEMUDIAN";
        }
    }
    
    public function getBulanKursus(){
        
        $bulan = '0';
        
        //$result = self::getsomthin();
        
        if ($this->tarikhMula != NULL){
            
            $dayyDateTime = \DateTime::createFromFormat('Y-m-d', $this->tarikhMula);
            $formatteddate = $dayyDateTime->format('m');
            $bulan = $formatteddate;
            
            return $bulan;
        } else {
            
            return $bulan;
        }
    }
    
    public function kursusListByMonth($dayonth)
    {
        $day = SiriLatihan::find()
                ->joinWith('sasaran3')
                ->where(['statusKursusLatihan' => 'AKTIF'])
                ->orderBy('tarikhMula');
        
        $dataProvider = new ActiveDataProvider([
            'query' => $day,
            'pagination' => false,
            'sort' =>false,
        ]);
        
        $filteredModels = [];
        //$filteredModels2 = [];
        
        foreach ($dataProvider->models as $dayodel){
            if ($dayodel->bulanKursus == $dayonth){
                $filteredModels[] = $dayodel;
                //$dataProvider->setModels($filteredModels);
            } 
            //else {
                //$filteredModels2[] = $dayodel;
                //$dataProvider->setModels($filteredModels2);
            //}
        }
        
        $dataProvider->setModels($filteredModels);
        
        return $dataProvider;
    }
    
    public function getTarikh($day){
        
        //$day = $bulan;
        if($day == 01){
            $day = "Januari";}
        elseif ($day == 02){
          $day = "Februari";}
        elseif ($day == 03){
          $day = "Mac";}
        elseif ($day == 04){
          $day = "April";}
        elseif ($day == 05){
          $day = "Mei";}
        elseif ($day == 06){
          $day = "Jun";}
        elseif ($day == 07){
          $day = "Julai";}
        elseif ($day == '08'){
          $day = "Ogos";}
        elseif ($day == '09'){
          $day = "September";}
        elseif ($day == '10'){
          $day = "Oktober";}
        elseif ($day == '11'){
          $day = "November";}
        elseif ($day == '12'){
          $day = "Disember";}
        else {
           $day = "TIDAK DITETAPKAN"; 
        }
          
        return $day;
    }
    
    public function getCampusName()
    {
        return $this->hasOne(IdpCampus::className(), ['campus_id'=>'kampusID']);
    }
    
    /** Relation **/
    public function getSasaran8(){
        //return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id'=>'iid']);
        return $this->hasMany(KursusSasaran::className(), ['siriLatihanID' => 'siriLatihanID']);
    }
    
    /** Relation **/
    public function getSasaran9(){
        //return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id'=>'iid']);
        return $this->hasMany(KursusJemputan::className(), ['siriLatihanID' => 'siriLatihanID']);
    }
    
    public function CheckKuota($siriLatihanID) {
        
        $ckuota = PermohonanLatihan::find()
                ->where(['siriLatihanID' => $siriLatihanID])
                ->count();
        
        return $ckuota;
    }
    
    public function getHari(){
        
        setlocale(LC_ALL, 'my_MY');
        
        $hariMula = $this->tarikhMula;
        $hariAkhir = $this->tarikhAkhir;
        
        $timestamp = strtotime($hariMula);
        //$day = date('l', $timestamp);
        
        $day = strftime('%A', $timestamp);
        
        //echo strftime("%A %d %B %Y", mktime(0, 0, 0, 12, 22, 1978));
        
        $timestamp2 = strtotime($hariAkhir);
        //$day2 = date('l', $timestamp2);
        
        $day2 = strftime('%A', $timestamp2);
        
        //var_dump($day);
        
        if($day == 'Sunday'){
            $day = "Ahad";}
        elseif ($day == 'Monday'){
          $day = "Isnin";}
        elseif ($day == 'Tuesday'){
          $day = "Selasa";}
        elseif ($day == 'Wednesday'){
          $day = "Rabu";}
        elseif ($day == 'Thursday'){
          $day = "Khamis";}
        elseif ($day == 'Friday'){
          $day = "Jumaat";}
        elseif ($day == 'Saturday'){
          $day = "Sabtu";}
          
        if($day2 == 'Sunday'){
            $day2 = "Ahad";}
        elseif ($day2 == 'Monday'){
          $day2 = "Isnin";}
        elseif ($day2 == 'Tuesday'){
          $day2 = "Selasa";}
        elseif ($day2 == 'Wednesday'){
          $day2 = "Rabu";}
        elseif ($day2 == 'Thursday'){
          $day2 = "Khamis";}
        elseif ($day2 == 'Friday'){
          $day2 = "Jumaat";}
        elseif ($day2 == 'Saturday'){
          $day2 = "Sabtu";}

        if ($day == $day2){
            return $day;
        } else {
            return $day.' - '.$day2;
        }
        
    }
    
    public function CheckPastProgram() {
        
        $today = date('Y-m-d');
        
        if ($this->tarikhMula <= $today){
            return 0;
        } else {
            return 1;
        }
    }
    
    public function getStatusSiri(){
        
        $status = '';
        
        if ($this->statusSiriLatihan == 'ACTIVE' || $this->statusSiriLatihan == 'AKTIF') {
            $status = '<span style="width:150px" class="label label-primary">AKTIF</span>';     
        } elseif ($this->statusSiriLatihan == 'SEDANG BERJALAN') {
            $status = '<span style="width:150px" class="label label-success">TELAH DIJALANKAN</span>';
        }  
        return $status;
    }
}
