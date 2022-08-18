<?php

namespace app\models\cbelajar;

use Yii;


/**
 * This is the model class for table "cbelajar.tbl_file_pemohon".
 *
 * @property int $id
 * @property string $icno
 * @property string $namafile Nama Fail
 * @property int $dokumenCd
 * @property string $jenisDokumen
 * @property string $uploaded_by
 */
class TblFilePemohon extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
     public $file;
    public static function tableName()
    {
        return 'hrd.cb_tbl_file_pemohon';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dokumenCd'], 'required'],
            [['namafile', 'uploaded_by'], 'safe'],
            [['namafile'], 'file','extensions'=>'pdf'],
            [['iklan_id','kategori'], 'integer'],
            [['namafile'], 'string', 'max' => 150],
            [['jenisDokumen'], 'string', 'max' => 60],
            [['dokumenCd', 'uploaded_by'], 'string', 'max' => 255],
            [['created_dt'], 'safe'],
            [['file'], 'file','extensions'=>'pdf','maxSize' => 5000000], 
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'namafile' => 'Nama Dokumen',
            'iklan_id' => 'Iklan ID',
            'dokumenCd' => 'Dokumen Cd',
            'jenisDokumen' => 'Jenis Dokumen',
            'uploaded_by' => 'Uploaded By',
            'created_dt' => 'Created Dt',
             'file' => 'Dokumen Sokongan',
        ];
    }


    public function getDokumen(){
        return $this->hasOne(TblDokumen::className(), ['id' => 'dokumenCd']);
    }

    public function getKategori() {
        return $this->hasOne(Dokumen::className(), ['id'=>'jenisDokumen']);
    }

    //  public function checkUpload($id){
    //     $model = TblDokumen::findOne(['dokumenCd' => Yii::$app->user->getId(),'id' => $id]); 
        
    //     return $model;
    // } 
    
     public function checkUploadFile($id){
        $file = TblFilePemohon::findAll(['uploaded_by' => Yii::$app->user->getId(),'dokumenCd' => $id]); 
        
        return $file;
    }
    
    public function checkUpload($id, $iklan){
        
        $model = TblFilePemohon::find()->where(['uploaded_by' => Yii::$app->user->getId(),'dokumenCd' => $id, 'iklan_id'=>$iklan])->all(); 
        
        return $model;
    } 
    public function checkUploads($id, $iklan){
        
        $model = TblFilePemohon::find()->where(['uploaded_by' => 950829125446,'dokumenCd' => $id, 'iklan_id'=>$iklan])->all(); 
        
        return $model;
    } 
     public function getKakitangan() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'uploaded_by']);
    }
    public function namafail($id)
    {
        $dokumen2 = \app\models\cbelajar\TblFilePemohon::findAll(['uploaded_by' =>$this->ICNO(),'iklan_id' => $id]);
return $dokumen2;
    }
      public function getSokongan() {
                  $dokumen2 = \app\models\cbelajar\TblFilePemohon::findAll(['uploaded_by' =>$this->ICNO(),'iklan_id' => $id]);
$ICNO =$dokumen2->uploaded_by;
        return $this->hasOne(TblFilePemohon::className(), ['dokumenCd'=>'id'])->where(['uploaded_by'=>$ICNO]);
    }
    
    
}