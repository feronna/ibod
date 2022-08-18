<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.tbl_dokumen_ln".
 *
 * @property int $id
 * @property string $nama_dokumen
 * @property string $dokumenCd
 * @property int $status
 */
class TblDokumenLn extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_tbl_dokumen_ln';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['nama_dokumen'], 'string', 'max' => 3000],
            [['dokumenCd'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_dokumen' => 'Nama Dokumen',
            'dokumenCd' => 'Dokumen Cd',
            'status' => 'Status',
        ];
    }
     public function getDokumen() {
        return $this->hasOne(TblDokumenLn::className(), ['dokumenCd'=>'dokumenCd']);
    }


     public function getNamaDokumen() {
        return $this->hasOne(TblDokumenLn::className(), ['nama_dokumen'=>'nama_dokumen']);
    }
     public function checkUpload($id, $iklan){
        $model = TblFileLn::find()->where(['uploaded_by' => Yii::$app->user->getId(),'dokumenCd' => $id, 'iklan_id'=>$iklan])->all(); 
        
        return $model;
    } 
    public function getSokongan() {
        
//        $model = TblFilePemohon::find()->where('uploaded_by'=)
        return $this->hasOne(TblFileLn::className(), ['dokumenCd'=>'id'])->where(['uploaded_by'=>Yii::$app->user->getId()]);
    }
    public function Sokonganby($ICNO) {
        
        $model = TblFileLn::find()->where(['dokumenCd' => $this->id])->andWhere(['uploaded_by' => $ICNO])->one();
        return $model;
        
    }
    
     public function checkUploada($icno,$id, $iklan){
        $model = TblFileLn::find()->where(['uploaded_by' => $icno,'dokumenCd' => $id, 'iklan_id'=>$iklan])->all(); 
        
        return $model;
    } 
    public function getSokongana() {
        
//        $model = TblFilePemohon::find()->where('uploaded_by'=)
        return $this->hasOne(TblFileLn::className(), ['dokumenCd'=>'id'])->where(['uploaded_by'=>Yii::$app->user->getId()]);
    }
}
