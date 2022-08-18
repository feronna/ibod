<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "hrd.cb_tbl_dean".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $icno
 * @property string $terima
 * @property int $idsem
 * @property string $result
 * @property string $comment
 * @property int $HighestEduLevelCd
 * @property string $created_dt
 * @property int $tahun
 */
class LkkDean extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
        public $file;

    public static function tableName()
    {
        return 'hrd.cb_tbl_dean';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'idsem', 'HighestEduLevelCd', 'tahun'], 'integer'],
            [['comment','d_comment','dokumen','namafile', 'result'], 'string'],
            [['created_dt'], 'safe'],
            [['icno'], 'string', 'max' => 12],
            [['terima'], 'string', 'max' => 50],
            [['status','status_d'], 'string', 'max' => 20],
            [['file'], 'file','extensions'=>'pdf','maxSize' => 5000000], 
            [['file' ],'safe'], 

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'icno' => 'Icno',
            'terima' => 'Terima',
            'idsem' => 'Idsem',
            'result' => 'Result',
            'comment' => 'Comment',
            'HighestEduLevelCd' => 'Highest Edu Level Cd',
            'created_dt' => 'Created Dt',
            'tahun' => 'Tahun',
            'namafile' => 'Nama Fail',
        ];
    }
     public function checkUpload($id){
        $model = LkkDean::find()->where(['icno' => Yii::$app->user->getId(),'dokumen' => 'cb_lkk_dean.id'])->one(); 
        
        return $model;
    } 
     public function getActivity() {
       
        return $this->hasOne(CbLkkDean::className(), ['id' => 'dokumen']);
       
   }
}
