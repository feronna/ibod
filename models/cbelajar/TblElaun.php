<?php

namespace app\models\cbelajar;

use Yii;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "hrd.cb_tbl_elaun".
 *
 * @property int $id
 * @property string $icno
 * @property string $jenis_elaun
 * @property string $bayaran KPT,UMS
 * @property string $amaun
 * @property int $bID
 */
class TblElaun extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_tbl_elaun';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amaun', 'bID', 'p_bayar', 'tempoh'], 'integer'],
            [['created_dt', 'dt_sbayar', 'dt_nbayar'], 'safe'],
            [['catatan'], 'string'],
            [['icno', 'update_by'], 'string', 'max' => 12],
            [['jenis_elaun', 'jenis_elaun_b', 'bayaran'], 'string', 'max' => 255],
            [['terima','semester'], 'string', 'max' => 20],
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
            'jenis_elaun' => 'Jenis Elaun',
            'bayaran' => 'Bayaran',
            'amaun' => 'Amaun',
            'bID' => 'B ID',
            'terima' => 'Terima',
            'created_dt' => 'Created Dt',
            'update_by' => 'Update By',
            'catatan' => 'Catatan',
            'p_bayar' => 'P Bayar',
            'dt_sbayar' => 'Dt Sbayar',
            'dt_nbayar' => 'Dt Nbayar',
            'tempoh' => 'Tempoh',
            'Semester' => 'Semester',
        ];
    }
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    public function getJenis() {
//       $a = explode(",", $id);
//       $namae = '';
//       foreach($a as $a){
//       $n = ElaunKadarB::find()->where(['id' => $a])->one()->elaun;
//        $namae = $namae."<br>".$n;
//}
//
//        return $namae;
////        return ($this->hasOne(RefTblElaunA::className(), ['id' => 'jenis_elaun']));
//       
//   }
////   public function getJenis() {
////     
    return ($this->hasOne(KadarB::className(), ['id' => 'jenis_elaun']));}
//       
//   }
   public function getAmaun() {
//       $a = explode(",", $id);
//       $namae = '';
//       foreach($a as $a){
//       $n = ElaunKadarB::find()->where(['id' => $a])->one()->kadar_b;
//        $namae = $namae."<br>".$n;
//}
//
//        return $namae;
        return ($this->hasOne(ElaunKadarB::className(), ['id' => 'jenis_elaun']));
       
   }
   public function getTempohpengajian(){
    

        $date1 = TblElaun::find()->where(['ICNO' => $this->icno, 'elaun'=>"KELUARGA"])->min('dt_sbayar');
        $date2 = TblElaun::find()->where(['ICNO' => $this->icno,  'elaun'=>"KELUARGA"])->min('dt_nbayar');

        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $months = 0;

        while (strtotime('+1 MONTH', $ts1) < $ts2) {
            $months++;
            $ts1 = strtotime('+1 MONTH', $ts1);
        }

        return $months. ' Bulan '. ($ts2 - $ts1) / (60*60*24) . ' Hari'; // 120 month, 26 days
    }
//    public function getElaun($id) {
//       $a = explode(",", $id);
//       $namae = '';
//       foreach($a as $a){
//       $n = RefTblElaunA::find()->where(['id' => $a])->one()->amaun;
//        $namae = $namae."<br>".$n;
//}
//
//        return $namae;
////        return ($this->hasOne(RefTblElaunA::className(), ['id' => 'jenis_elaun']));
//       
//   }
  public function getJum() {
      
      
              return ($this->hasOne(RefTblElaunA::className(), ['id' => 'jenis_elaun']));

       
   }
    public function getE() {
       
        return $this->hasOne(TblElaunLulus::className(), ['icno' => 'icno']);
       
   }
   
   public function getLah() {
        if($this->jum){
            return $this->jum->amaun;
        }
        
         return "Tidak Berkaitan";
    }
   public function getMasa(){
       
       $date1 = strtotime("dt_sbayar");
$date2 = strtotime("dt_nbayar");

$timeDiff = abs($date2 - $date1);

$numberDays = $timeDiff/86400;  // 86400 seconds in one day

// and you might want to convert to integer
return $numberDays = intval($numberDays);
//        $date1 = TblElaun::find()->where(['ICNO' => $this->icno])->max('dt_stbayar');
//        $date2 = TblElaun::find()->where(['ICNO' => $this->icno])->max('dt_nbayar');
//
//        $ts1 = strtotime($date1);
//        $ts2 = strtotime($date2);
//
//        $months = 0;
//
//        while (strtotime('+1 MONTH', $ts1) < $ts2) {
//            $months++;
//            $ts1 = strtotime('+1 MONTH', $ts1);
//        }

//        return $months. ' Bulan '. ($ts2 - $ts1) / (60*60*24). ' Hari'; // 120 month, 26 days
    } 
   
//   public function actionJenise($id){
//$a = explode(",", $id);
//$namae = '';
//foreach($a as $a){
//   $n = refelaun::find(['id' => $a])->one()->nama_elaun;
//   $namae = $namae."<br>".$n;
//}

//return $namae;}
   public function getJenise() {
       
        return ($this->hasOne(ElaunKadar::className(), ['id' => 'jenis_elaun']));
       
   }
}
