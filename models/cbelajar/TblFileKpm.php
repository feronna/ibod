<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.tbl_file_kpm".
 *
 * @property int $id
 * @property int $iklan_id
 * @property string $namafile
 * @property string $dokumenCd
 * @property string $uploaded_by
 * @property string $created_dt
 * @property int $tahun
 */
class TblFileKpm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
//     public $file2;
    public static function tableName()
    {
        return 'hrd.cb_tbl_file_kpm';
    }

    /**
     * {@inheritdoc}
     */
    
    public function rules()
    {
        return [
            [['iklan_id'], 'required'],
            [['iklan_id', 'tahun'], 'integer'],
            [['created_dt'], 'safe'],
            [['namafile'], 'file','extensions'=>'pdf'],
            [['dokumenCd'], 'string', 'max' => 255],
            [['uploaded_by'], 'string', 'max' => 12],
//            [['file2'], 'file','extensions'=>'pdf'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'iklan_id' => 'Iklan ID',
            'namafile' => 'Namafile',
            'dokumenCd' => 'Dokumen Cd',
            'uploaded_by' => 'Uploaded By',
            'created_dt' => 'Created Dt',
            'tahun' => 'Tahun',
        ];
    }
    
     public function getDokumen(){
        return $this->hasOne(TblDokumenKpm::className(), ['id' => 'dokumenCd']);
    }

    public function getKategori() {
        return $this->hasOne(Dokumen::className(), ['id'=>'jenisDokumen']);
    }

//      public function checkUpload($id){
//         $model = TblDokumen::findOne(['dokumenCd' => Yii::$app->user->getId(),'id' => $id]); 
//        
//        return $model;
//   } 
    
//     public function checkUploadFile($id, $iklan){
//        $file = TblFileKpm::findAll(['uploaded_by' => Yii::$app->user->getId(), 'dokumenCd'=> $id,'iklan_id' => $id]); 
//        
//        return $file;
//    }
    
    public function checkUpload($id, $iklan){
        $model = TblFileKpm::find()->where(['uploaded_by' => Yii::$app->user->getId(),'dokumenCd' => $id, 'iklan_id'=>$iklan])->all(); 
        
        return $model;
    } 
     public function getKakitangan() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'uploaded_by']);
    }
    public function getMohon() {
        return $this->hasOne(TblPermohonan::className(), ['icno' => 'uploaded_by']);
    }
}
