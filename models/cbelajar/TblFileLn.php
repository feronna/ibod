<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.tbl_file_ln".
 *
 * @property int $id
 * @property int $iklan_id
 * @property string $dokumenCd
 * @property string $uploaded_by
 * @property string $created_dt
 * @property int $tahun
 */
class TblFileLn extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_tbl_file_ln';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iklan_id'], 'required'],
            [['iklan_id', 'tahun'], 'integer'],
            [['namafile'], 'file','extensions'=>'pdf'],
            [['created_dt'], 'safe'],
            [['dokumenCd'], 'string', 'max' => 255],
            [['uploaded_by'], 'string', 'max' => 12],
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
        return $this->hasOne(TblDokumenLn::className(), ['id' => 'dokumenCd']);
    }

    public function getKategori() {
        return $this->hasOne(Dokumen::className(), ['id'=>'jenisDokumen']);
    }

    //  public function checkUpload($id){
    //     $model = TblDokumen::findOne(['dokumenCd' => Yii::$app->user->getId(),'id' => $id]); 
        
    //     return $model;
    // } 
    
     public function checkUploadFile($id){
        $file = TblFileLn::findAll(['uploaded_by' => Yii::$app->user->getId(),'iklan_id' => $id]); 
        
        return $file;
    }
      public function getSokongan() {
        
//        $model = TblFilePemohon::find()->where('uploaded_by'=)
        return $this->hasOne(TblFileLn::className(), ['dokumenCd'=>'id'])->where(['uploaded_by'=>Yii::$app->user->getId()]);
    }

}
