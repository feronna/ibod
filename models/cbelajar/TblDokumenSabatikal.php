<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.tbl_dokumen_sabatikal".
 *
 * @property int $id
 * @property string $nama_dokumen
 * @property int $dokumenCd
 * @property int $status
 */
class TblDokumenSabatikal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_tbl_dokumen_sabatikal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_dokumen'], 'string'],
            [['dokumenCd', 'status'], 'integer'],
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
     public function getDokumen2() {
        return $this->hasOne(TblDokumenSabatikal::className(), ['id'=>'id']);
    }


     public function getNamaDokumen() {
        return $this->hasOne(TblDokumenSabatikal::className(), ['nama_dokumen'=>'nama_dokumen']);
    }


    public function checkUpload($id, $iklan){
        $model = TblFilePemohon::find()->where(['uploaded_by' => Yii::$app->user->getId(),'dokumenCd' => $id, 'iklan_id'=>$iklan,'idBorang' => 2])->all(); 
        
        return $model;
    } 
}
