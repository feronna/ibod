<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.tbl_dokumen".
 *
 * @property int $id
 * @property string $nama_dokumen
 * @property int $dokumenCd
 * @property int $jenisDokumen
 */
class TblDokumen extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public $file, $file2;

    public static function tableName() {
        return 'hrd.cb_tbl_dokumen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['dokumenCd', 'status'], 'integer'],
            [['nama_dokumen'], 'string', 'max' => 3000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'nama_dokumen' => 'Nama Dokumen',
            'dokumenCd' => 'Dokumen Cd',
//            'jenisDokumen' => 'Jenis Dokumen',
            'status' => 'Status',
        ];
    }

    public function getDokumen() {
        return $this->hasOne(TblDokumen::className(), ['dokumenCd' => 'dokumenCd']);
    }

    public function getDokumens() {
        return $this->hasOne(TblDokumen::className(), ['dokumenCd' => 'id', 'kategori' => 4]);
    }

    public function getNamaDokumen() {
        return $this->hasOne(TblDokumen::className(), ['nama_dokumen' => 'nama_dokumen']);
    }

//    public function checkUpload($id, $iklan){
//        $model = TblFilePemohon::find()->where(['uploaded_by' => Yii::$app->user->getId(),'dokumenCd' => $id, 'iklan_id'=>$iklan])->all(); 
//        
//        return $model;
//    } 

    public function checkUploads($id, $iklan) {
        $model = TblFilePemohon::find()->where(['dokumenCd' => $id, 'uploaded_by' => Yii::$app->user->getId(), 'iklan_id' => $iklan, 'idBorang' => 2])->all();

        return $model;
    }

    public function getS() {

        return $this->hasOne(TblPengajian::className(), ['icno' => 'icno'])->where(['status' => [9, 1, 10]]);
    }

//    public function checkUpload($id, $iklan){
//        $model = TblFileKpm::find()->where(['uploaded_by' => Yii::$app->user->getId(),'dokumenCd' => $id, 'iklan_id'=>$iklan])->all(); 
//        
//        return $model;
//    } 
//    

    public function checkUpload($id, $iklan) {
        $model = TblFilePemohon::find()->where(['uploaded_by' => Yii::$app->user->getId(),
                    'dokumenCd' => $id, 'iklan_id' => $iklan])->all();

        return $model;
    }

    public function getSokongan() {

//        $model = TblFilePemohon::find()->where('uploaded_by'=)
        return $this->hasOne(TblFilePemohon::className(), ['dokumenCd' => 'id'])->where(['uploaded_by' => Yii::$app->user->getId()]);
    }
    public function Sokonganby($ICNO) {
        
        $model = TblFilePemohon::find()->where(['dokumenCd' => $this->id])->andWhere(['uploaded_by' => $ICNO])->one();
        return $model;
//var_dump;die;
//    return $this->hasOne(TblFilePemohon::className(), ['dokumenCd' => 'id'])->onCondition(['uploaded_by' => $ICNO]);
        
//        $model = TblFilePemohon::find()->where(['uploaded_by'=>$icno])->one();
        
//        return $this->hasOne(TblFilePemohon::className(), ['dokumenCd' => 'id'])->onCondition(['uploaded_by' => $ICNO]);
    }

    public function checkUploada($icno, $id, $iklan) {
        $exist = TblFilePemohon::find()->where(['uploaded_by' => $icno, 'dokumenCd' => $id, 'iklan_id' => $iklan])->exists();

        return $exist;
    }
        public function checkUploadj($icno, $id, $iklan) {
        $model = TblFilePemohon::find()->where(['uploaded_by' => $icno,'dokumenCd' => $id, 'iklan_id' => $iklan])->all();

        return $model;
    }
    
    public function getSokonganj($icno, $id, $iklan) {
        $model = TblFilePemohon::find()->where(['uploaded_by' => $icno,'dokumenCd' => $id, 'iklan_id' => $iklan])->all();

        return $model;
    }


    public function getSokongana() {

//        $model = TblFilePemohon::find()->where('uploaded_by'=)
        return $this->hasOne(TblFilePemohon::className(), ['dokumenCd' => 'id']);
    }

}
