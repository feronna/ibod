<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "{{%myidp.tbl_kehadiranjfpiu}}".
 *
 * @property int $slotID
 * @property string $staffID
 * @property string $tarikhMasa
 * @property int $kategoriKursusID
 */
class KehadiranJfpiu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%myidp.tbl_kehadiranjfpiu}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slotID', 'staffID'], 'required'],
            [['slotID', 'kategoriKursusID'], 'integer'],
            [['tarikhMasa'], 'safe'],
            [['staffID'], 'string', 'max' => 12],
            [['slotID', 'staffID'], 'unique', 'targetAttribute' => ['slotID', 'staffID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'slotID' => 'Slot ID',
            'staffID' => 'Staff ID',
            'tarikhMasa' => 'Tarikh Masa',
            'kategoriKursusID' => 'Kategori Kursus ID',
        ];
    }
    
    /** Relation **/
    // KursusLatihan[kategoriJawatanID] == IdpKategoriJawatan[kategoriJawatanID] 
    public function getPeserta()
    {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO'=>'staffID']);
    }
    
    /** Relation **/
    public function getSasaran9(){
        //return $this->hasOne(VIdpSenaraiKursus::className(), ['kursus_id'=>'iid']);
        return $this->hasOne(SlotLatihanJfpiu::className(), ['slotID' => 'slotID']);
    }
    
    public function getJenisKursus(){

        $a = "TIADA DATA";
        
        if ($this->kategoriKursusID != 0){
            
            
            if ($this->kategoriKursusID == 1){
                $a = '<span class="label label-default">UMUM</span>';    
            } elseif ($this->kategoriKursusID == 3) {
                $a = '<span class="label label-danger">TERAS</span>';
            } elseif ($this->kategoriKursusID == 4) {
                $a = '<span class="label label-danger">ELEKTIF</span>';
            } elseif ($this->kategoriKursusID == 5) {
                $a = '<span class="label label-success">TERAS UNIVERSITI</span>';
            } elseif ($this->kategoriKursusID == 6) {
                $a = '<span class="label label-danger">TERAS SKIM</span>';
            } elseif ($this->kategoriKursusID == 7) {
                $a = '<span class="label label-success">IMPAK TINGGI</span>';
            }
            
            return $a;
            
        } else {
            
            $checkKompetensi = KursusLatihan::find()
                    ->where(['kursusLatihanID' => $this->sasaran9->sasaran4->kursusLatihanID])
                    ->one();
            
            if ($checkKompetensi == NULL){
            //$a = '<span class="label label-success">BUKAN SASARAN</span>';
                $a = Html::button('UBAH', ['value' => 'ubah-jenis-kursus?slotID='.$this->slotID.'&peserta='.$this->staffID, 'class' => 'mapBtn btn-sm btn-danger btn-block']);
            } else {
                $a = $this->sasaran9->sasaran4->sasaran3->kompetensii;
//                $this->kategoriKursusID = $this->sasaran9->sasaran4->sasaran3->kompetensi;
//                $this->save(false);
            }
            
            return $a;
            
        }    
    }
    
    public function getTarikhKursus(){
        
        //$myDateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $this->tarikhMasa);
        //$formatteddate = $myDateTime->format('d-m-Y H:i:s');
        
        $formatteddate = date('d-m-Y h:i:s A', strtotime($this->tarikhMasa));
        
        return $formatteddate;
    }
    
    public function calculateMataUmum($siriLatihanID)
    {
        $mataaa = 0;
        
        $mata = SlotLatihan::find()
                    ->joinWith('sasaran55')
                    ->where(['siriLatihanID' => $siriLatihanID])
                    ->andWhere(['kehadiran.staffID' => Yii::$app->user->getId()])
                    ->all();

        foreach ($mata as $mataa){
            $mataaa = $mataaa + $mataa->mataSlot;
            //$mataaa = $mataaa + 1;
        }
        
        return $mataaa;
    }
    
    public function calculateMata($siriLatihanID)
    {
        $mataaa = 0;
        
        $mata = SlotLatihan::find()
                    ->joinWith('sasaran55')
                    ->where(['siriLatihanID' => $siriLatihanID])
                    ->andWhere(['kehadiran.staffID' => Yii::$app->user->getId()])
                    ->all();

        foreach ($mata as $mataa){
            $mataaa = $mataaa + $mataa->mataSlot;
        }
        
        $kursus = SiriLatihan::find()
                ->where(['siriLatihanID' => $siriLatihanID])
                ->one();
        
//        var_dump($kursus->kursusLatihanID);
//        die();
        
//        $checkBorang = BorangPenilaianLatihan::find()
//                ->where(['kursusLatihanID' => $kursus->kursusLatihanID])
//                ->andWhere(['pesertaID' => Yii::$app->user->getId()])
//                ->one();
        
        $checkBorang = BorangPenilaianLatihan::find()
                ->where(['siriLatihanID' => $siriLatihanID])
                ->andWhere(['pesertaID' => Yii::$app->user->getId()])
                ->one();
        
        if ($checkBorang){
            
            if ($checkBorang->statusBorang == '2') {
            
                return $mataaa;
            } else {
                return Html::button('<i class="fa fa-pencil" aria-hidden="true"></i> BORANG PENILAIAN LATIHAN', ['value' => 'borangpenilaianlatihan?id='.$siriLatihanID, 'class' => 'mapBtn btn-sm btn-danger btn-block']);
            }
            
        } else {
            
//            $checkBorang = BorangPenilaianLatihan::find()
//                ->where(['pesertaID' => $pesertaID])
//                ->andWhere(['kursusLatihanID' => $kursusID])
//                ->one();
                
//            $checkBorangK = BorangPenilaianKeberkesanan::find()
//                ->where(['pesertaID' => Yii::$app->user->getId()])
//                ->andWhere(['kursusLatihanID' => $kursus->kursusLatihanID])
//                ->one();

            $checkBorangK = BorangPenilaianKeberkesanan::find()
                    ->where(['pesertaID' => Yii::$app->user->getId()])
                    ->andWhere(['siriLatihanID' => $siriLatihanID])
                    ->one();
            
                if (!$checkBorangK){
                        $borangpl = new BorangPenilaianLatihan();
                        $borangpl->pesertaID = Yii::$app->user->getId();
                        //$borangpl->kursusLatihanID = $kursusID->kursusLatihanID;
                        $borangpl->siriLatihanID = $siriLatihanID;
                        $borangpl->statusBorang = '1';
                        //$borangpl->save(false);

                        $borangpk = new BorangPenilaianKeberkesanan();
                        $borangpk->pesertaID = Yii::$app->user->getId();
                        //$borangpk->kursusLatihanID = $kursusID->kursusLatihanID;
                        $borangpk->siriLatihanID = $siriLatihanID;
                        $borangpk->statusBorang = '1';
                        //$borangpk->save(false);
                    
                    if ($borangpl->save() && $borangpk->save()){
                        return Html::button('<i class="fa fa-pencil" aria-hidden="true"></i> BORANG PENILAIAN LATIHAN', ['value' => 'borangpenilaianlatihan?id='.$siriLatihanID, 'class' => 'mapBtn btn-sm btn-danger btn-block']);
                    } else {
                        return "RALAT";
                    }

                }
        }   
    }
    
    public function calculateMataTotal($jenis)
    {
        $mataaa = 0;
        
        $elektif = SlotLatihan::find()
                    ->joinWith('sasaran55')
                    ->where(['kehadiran.staffID' => Yii::$app->user->getId()])
                    ->andWhere(['kehadiran.kategoriKursusID' => $jenis])
                    ->all();
        
        foreach ($elektif as $mataa){
            
            if($jenis != '1'){
            
                $checkBorang = BorangPenilaianLatihan::find()
                    ->where(['siriLatihanID' => $mataa->siriLatihanID])
                    ->andWhere(['pesertaID' => Yii::$app->user->getId()])
                    ->andWhere(['statusBorang' => 2])
                    ->one();

    //            $checkBorangK = BorangPenilaianKeberkesanan::find()
    //                    ->where(['pesertaID' => Yii::$app->user->getId()])
    //                    ->andWhere(['siriLatihanID' => $elektif->siriLatihanID])
    //                    ->andWhere(['statusBorang' => 2])
    //                    ->one();

                if ($checkBorang){
                    $mataaa = $mataaa + $mataa->mataSlot;
                }
            } else {
                $mataaa = $mataaa + $mataa->mataSlot;
            }
        }
        
        return $mataaa;
        
    }
    
    public function getMata($jenis){
        
        $currentYear = date('Y');
        
        $model2 = IdpMata::find()
                ->where(['staffID' => Yii::$app->user->getId()])
                ->andWhere(['tahun' => $currentYear])
                ->one();
        
        if ($jenis == 'teras'){
        
            return $model2->mataTeras;
        
        } elseif ($jenis == 'elektif') {
            
            return $model2->mataElektif;
            
        } elseif ($jenis == 'umum') {
            
            return $model2->mataUmum;
            
        } elseif ($jenis == 'terasUni') {
            
            return $model2->mataTerasUni;
            
        } elseif ($jenis == 'terasSkim') {
            
            return $model2->mataTerasSkim;
        }
    }
}
