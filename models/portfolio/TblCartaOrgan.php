<?php

namespace app\models\portfolio;

use Yii;

/**
 * This is the model class for table "hrm.portfolio_tbl_carta_organ".
 *
 * @property int $id
 * @property string $icno
 * @property int $jd_id
 * @property string $nama_dokumen
 * @property string $catatan
 */
class TblCartaOrgan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
        public $files;

    public static function tableName()
    {
        return 'hrm.portfolio_tbl_carta_organ';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
          
            [['icno_meluluskan', 'tarikh_diluluskan', 'file', 'mesyuarat_meluluskan'], 'string'],
            [['icno'], 'string', 'max' => 15],
            [['files'], 'file','extensions'=>'pdf','maxSize'=>6666240, 'tooBig' => 'Limit is 6MB'], 

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
            'jd_id' => 'Jd ID',
            'nama_dokumen' => 'Nama Dokumen',
            'catatan' => 'Catatan',
        ];
    }
    
        public function getKakitanganMelulus() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'icno_meluluskan']);
    }
      public function checkUpload($id){
        $model = TblCartaOrgan::findOne(['icno' => Yii::$app->user->getId(),'dept_id' => $id]); 
        
        return $model;
    } 
       
}
