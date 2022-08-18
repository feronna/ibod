<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "{{%myidp.tbl_kursuslatihanjfpiu}}".
 *
 * @property int $kursusLatihanID
 * @property string $tajukLatihan
 * @property string $penggubalModul
 * @property string $tahunTawaran
 * @property string $kategoriJawatanID
 * @property int $klusterID
 * @property string $jenisLatihanID
 * @property string $sinopsisKursus
 * @property string $statusKursusLatihan
 * @property string $kursusImpakTinggi
 * @property string $unitBertanggungjawab
 * @property int $kompetensi
 */
class KursusLatihanJfpiu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%myidp.tbl_kursuslatihanjfpiu}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['klusterID', 'kompetensi'], 'integer'],
            [['sinopsisKursus'], 'string'],
            [['tajukLatihan'], 'string', 'max' => 255],
            [['penggubalModul'], 'string', 'max' => 100],
            [['tahunTawaran'], 'string', 'max' => 4],
            [['kategoriJawatanID', 'jenisLatihanID', 'statusKursusLatihan', 'unitBertanggungjawab'], 'string', 'max' => 25],
            [['kursusImpakTinggi'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kursusLatihanID' => 'Kursus Latihan ID',
            'tajukLatihan' => 'Tajuk Latihan',
            'penggubalModul' => 'Penggubal Modul',
            'tahunTawaran' => 'Tahun Tawaran',
            'kategoriJawatanID' => 'Kategori Jawatan ID',
            'klusterID' => 'Kluster ID',
            'jenisLatihanID' => 'Jenis Latihan ID',
            'sinopsisKursus' => 'Sinopsis Kursus',
            'statusKursusLatihan' => 'Status Kursus Latihan',
            'kursusImpakTinggi' => 'Kursus Impak Tinggi',
            'unitBertanggungjawab' => 'Unit Bertanggungjawab',
            'kompetensi' => 'Kompetensi',
        ];
    }
    
    /** Relation **/
    // KursusLatihan[kategoriJawatanID] == IdpKategoriJawatan[kategoriJawatanID] 
    public function getKategoriJawatan()
    {
        return $this->hasOne(IdpKategoriJawatan::className(), ['kategoriJawatanID'=>'kategoriJawatanID']);
    }
    
    /** Relation **/
    // KursusLatihan[KampusID] == IdpCampus[campus_id] 
    public function getCampusName()
    {
        return $this->hasOne(IdpCampus::className(), ['campus_id'=>'kampusID']);
    }
    
    /** Relation **/
    // KursusLatihan[kategoriJawatanID] == IdpKategoriJawatan[kategoriJawatanID] 
    public function getPenceramah()
    {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO'=>'penceramahID']);
    }

    public function getKepakaran()
    {
        return $this->hasMany(\app\models\hronline\Tblbidangkepakaran::className(), ['ICNO' => 'penceramahID']);
    }
    
    public function getKlusterKursus()
    {
        return $this->hasOne(KlusterKursus::className(), ['kluster_id'=>'klusterID']);
    }
    
    public function getKompetensiii()
    {
        return $this->hasOne(Kategori::className(), ['kategori_id'=>'kompetensi']);
    }
    
    public function getSasarann(){
        return $this->hasMany(SiriLatihanJfpiu::className(), ['kursusLatihanID' => 'kursusLatihanID']);
    }

    /** Function to list out 'senarai kursus/latihan for 'urusetiaLatihan' based on current year **/
    public function getSenaraiKursus()
    { //uncalled function
        
        //get current year
        $currentYear = date('Y');
        
        $senaraiKursusDP = new ActiveDataProvider([
                    'query' => KursusLatihanJfpiu::find()->where(['tahunTawaran' => $currentYear]),
                    'pagination' => ['pageSize' => 30,],
                    ]);
        
        return $senaraiKursusDP;
    }
    
    public function getYearsList()
    {
        $currentYear = date('Y');
        $yearFrom = 2013;
        $yearsRange = range($yearFrom, $currentYear);
        return array_combine($yearsRange, $yearsRange);
    }
    
    public function CheckPohon($kursusLatihanID) {
        
        $userID = Yii::$app->user->getId();
        
        $cpohon = PermohonanLatihan::find()
                ->where(['kursusLatihanID' => $kursusLatihanID])  
                ->andWhere(['staffID' => $userID])
                ->one();
        
        if ($cpohon){
        
            if ($cpohon->caraPermohonan == 'jemputan'){
                return 1;
            } elseif ($cpohon->caraPermohonan == 'sendiriMohon'){
                return 2;
            } 
        } else {
            return 0;
        }
    }
    
    public function CheckHadir($kursusLatihanID) {
        
        $userID = Yii::$app->user->getId();
        
        $checkPeserta = Kehadiran::find()
                ->joinWith('sasaran9.sasaran4.sasaran3')
                ->where(['staffID' => $userID])
                ->andWhere(['kursusLatihan.kursusLatihanID' => $kursusLatihanID])
                ->one();
        
        if ($checkPeserta){
            return 1;
        } else {
            return 0;
        }
    }
    
    public function getBorang()
    {
        return $this->hasMany(BorangPenilaianLatihan::className(), ['kursusLatihanID' => 'kursusLatihanID']);
    }
    
    public function getKompetensii(){

        $a = "TIADA DATA";
        
        if ($this->kompetensi != 0){
            
            if ($this->kompetensi == 1){
                $a = '<span class="label label-default">UMUM</span>';    
            } elseif ($this->kompetensi == 3) {
                $a = '<span class="label label-danger">TERAS</span>';
            } elseif ($this->kompetensi == 4) {
                $a = '<span class="label label-danger">ELEKTIF</span>';
            } elseif ($this->kompetensi == 5) {
                $a = '<span class="label label-success">TERAS UNIVERSITI</span>';
            } elseif ($this->kompetensi == 6) {
                $a = '<span class="label label-danger">TERAS SKIM</span>';
            } elseif ($this->kompetensi == 7) {
                $a = '<span class="label label-success">IMPAK TINGGI</span>';
            }
            
            return $a;
            
        } 
//        else {
//            //$a = '<span class="label label-success">BUKAN SASARAN</span>';
//            $a = Html::button('UBAH', ['value' => 'ubah-jenis-kursus?slotID='.$this->slotID.'&peserta='.$this->staffID, 'class' => 'mapBtn btn-sm btn-danger btn-block']);
//
//            return $a;
//            
//        }    
    }
}
