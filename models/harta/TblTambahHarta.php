<?php

namespace app\models\harta;

use Yii;
use app\models\harta\Tblrefacqsrc;
use app\models\harta\Tblreffinancialsourcetype;
use app\models\hronline\Negara;
use app\models\hronline\Negeri;
use app\models\hronline\Bandar;
/**
 * This is the model class for table "harta.tbl_tambah_harta".
 *
 * @property int $id
 * @property int $harta_id
 * @property string $icno ICNo
 * @property string $hartaCd
 * @property int $senarai_id
 * @property int $hartas_id
 * @property string $pemilikan
 * @property string $AlDesc Asset information Description
 * @property string $AlAcqDt Asset Acquired Date
 * @property string $AlPurchasedValue Asset Purchased Value
 * @property string $AcqSrcCd Acquired Source
 * @property string $AlAssetCertNo Asset Certificate Number
 * @property string $AlCurVal Asset Current Value
 * @property string $AlQuantity Asset Quantity
 * @property string $AlAddr1 Asset Information Address(I)
 * @property string $AlAddr2 Asset Information Address (II)
 * @property string $AlAddr3 Asset Information Adress (III)
 * @property string $AlPostcode Asset Information Postcode
 * @property string $CityCd Asset City
 * @property string $StateCd Asset State
 * @property string $CountryCd Asset Country
 * @property string $ADDeclDt Asset Declaration Date
 * @property string $ADEdrsdDt Asset Endorsed Date
 * @property int $ADEdrsdBy Asset Endorsed By (COid, rujuk pada sistem HRMIS)
 * @property string $ADEdrsdRefNo Asset Endorsed Reference Number (No ruj. Surat menyatakan surat telah disahkan)
 * @property string $FinclSrcTypeCd Financial Source Type Code
 * @property string $FinclSrcTotalAmt Financial Source Total Amount
 * @property string $FinclSrcRepaymtPeriod Financial Source Repayment Period
 * @property string $FinclSrcMthlyInstalmt Financial Source Monthly Installment
 * @property string $FinclSrcInstlmtStDt Finance Source Installment Start Date
 * @property string $FinclSrcInstlmtEndDt Finance Source Installment End Date
 * @property string $status
 * @property string $status_padam
 */
class TblTambahHarta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.harta_tbl_tambah_harta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['harta_id', 'senarai_id', 'hartas_id'], 'required', 'message' => 'Wajib Diisi'],
            [['icno'], 'required'],
            [['AlPurchasedValue', 'AlCurVal', 'FinclSrcMthlyInstalmt'], 'number'],
            [['icno','AlPostcode'], 'string', 'max' => 12],
            [['AcqSrcCd', 'pinjaman', 'cara'], 'string', 'max' => 80],
            [['hartaCd'], 'string', 'max' => 10],
            [['pemilikan',  'AlAddr1', 'AlAddr2', 'AlAddr3', 'ADDeclDt', 'ADEdrsdDt', 'ADEdrsdRefNo', 'status', 'status_padam'], 'string', 'max' => 50],
            [['AlDesc', 'AlQuantity'], 'string', 'max' => 300],
            [['AlAssetCertNo'], 'string', 'max' => 20],
            [['CityCd'], 'string', 'max' => 6],
            [['StateCd', 'FinclSrcTypeCd'], 'string', 'max' => 80],
            [['CountryCd', 'FinclSrcRepaymtPeriod'], 'string', 'max' => 3],
            [['FinclSrcTotalAmt'], 'string', 'max' => 80],
            [['pemilikan', 'AlAssetCertNo',  'AlQuantity', 'AlPostcode','CityCd', 'StateCd','CountryCd','AlAcqDt', 'AcqSrcCd',
            'FinclSrcTotalAmt', 'AlPurchasedValue' , 'FinclSrcTotalAmt', 'AlDesc', 'FinclSrcTypeCd'], 'required', 'message' => "Wajib Diisi"],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'harta_id' => 'Harta ID',
            'icno' => 'Icno',
            'hartaCd' => 'Harta Cd',
            'senarai_id' => 'Senarai ID',
            'hartas_id' => 'Hartas ID',
            'pemilikan' => 'Pemilikan',
            'AlDesc' => 'Al Desc',
            'AlAcqDt' => 'Al Acq Dt',
            'AlPurchasedValue' => 'Al Purchased Value',
            'AcqSrcCd' => 'Acq Src Cd',
            'AlAssetCertNo' => 'Al Asset Cert No',
            'AlCurVal' => 'Al Cur Val',
            'AlQuantity' => 'Al Quantity',
            'AlAddr1' => 'Al Addr1',
            'AlAddr2' => 'Al Addr2',
            'AlAddr3' => 'Al Addr3',
            'AlPostcode' => 'Al Postcode',
            'CityCd' => 'City Cd',
            'StateCd' => 'State Cd',
            'CountryCd' => 'Country Cd',
            'ADDeclDt' => 'Ad Decl Dt',
            'ADEdrsdDt' => 'Ad Edrsd Dt',
            'ADEdrsdBy' => 'Ad Edrsd By',
            'ADEdrsdRefNo' => 'Ad Edrsd Ref No',
            'FinclSrcTypeCd' => 'Fincl Src Type Cd',
            'FinclSrcTotalAmt' => 'Fincl Src Total Amt',
            'FinclSrcRepaymtPeriod' => 'Fincl Src Repaymt Period',
            'FinclSrcMthlyInstalmt' => 'Fincl Src Mthly Instalmt',
            'FinclSrcInstlmtStDt' => 'Fincl Src Instlmt St Dt',
            'FinclSrcInstlmtEndDt' => 'Fincl Src Instlmt End Dt',
            'pinjaman' => 'Pinjaman Lain',
            'cara' => 'cara',
            'status' => 'Status',
            'status_padam' => 'Status Padam',
        ];
    }
    
      public function getHta() {
        return $this->hasOne(TblJenisHarta::className(), ['hartaCd' => 'hartaCd']);
    }
    
     public function getJenisHarta() {
        return $this->hasOne(TblSenarai::className(), ['senarai_id' => 'senarai_id']);
    }
    
     public function getSpesifikasiHarta() {
        return $this->hasOne(TblKeteranganHarta::className(), ['hartas_id' => 'hartas_id']);
    }
    
      public function getSumberKewangan() {
        return $this->hasOne(Tblreffinancialsourcetype::className(), ['FinclSrcTypeCd' => 'FinclSrcTypeCd']);
    }
    
     public function getCaraDiperolehi() {
        return $this->hasOne(Tblrefacqsrc::className(), ['AcqSrcCd' => 'AcqSrcCd']);
    }
    
     public function getNegara() {
        return $this->hasOne(Negara::className(), ['CountryCd' => 'CountryCd']);
    }

    public function getNegeri() {
        return $this->hasOne(Negeri::className(), ['StateCd' => 'StateCd']);
    }

    public function getBandar() {
        return $this->hasOne(Bandar::className(), ['CityCd' => 'CityCd']);
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
          
        return date_format(date_create($bulan), "d").' '.$m.' '.date_format(date_create($bulan), "Y ");
    }
    public function getTarikhPemilikan() {
        return  $this->getTarikh($this->AlAcqDt);
    }
    
      public function getTarikhMulaBayar() {
        return  $this->getTarikh($this->FinclSrcInstlmtStDt);
    }
    
     public function getTarikhAkhirBayar() {
        return  $this->getTarikh($this->FinclSrcInstlmtEndDt);
    }
    
     public function getCaraDiperolehi2() {
       
            return $this->caraDiperolehi->AcqSrcNm;
        
    } 
    
       public function getSumberKewangan2() {
      
            return $this->sumberKewangan->FinclSrcTypeNm;
        
    } 
    
 
}
