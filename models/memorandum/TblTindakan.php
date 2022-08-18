<?php

namespace app\models\memorandum;
use app\models\hronline\Tblprcobiodata;
use Yii;

use app\models\hronline\Department;
use app\models\memorandum\TblTindakan;
use app\models\memorandum\TblMaklumbalasPtj;
/**
 * This is the model class for table "utilities.memo_tbl_tindakan".
 *
 * @property int $id
 * @property int $id_rekod
 * @property string $penyelia
 * @property string $pegawai_peraku
 * @property int $dept_id
 * @property string $updated
 * @property string $updated_by
 */
class TblTindakan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.memo_tbl_tindakan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_rekod', 'dept_id'], 'integer'],
            [['updated'], 'safe'],
            [['penyelia', 'pegawai_peraku', 'updated_by'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_rekod' => 'Id Rekod',
            'penyelia' => 'Penyelia',
            'pegawai_peraku' => 'Pegawai Peraku',
            'dept_id' => 'Dept ID',
            'updated' => 'Updated',
            'updated_by' => 'Updated By',
        ];
    }
    
          public function getPenyelia2() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'penyelia']);
    }
    
          public function getPegawaiPeraku() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'pegawai_peraku']);
    }
    
         public function getDepartment() {
        return $this->hasOne(Department::className(), ['id' => 'dept_id']);
    }
    
    
        public function getTindakanPenyelia() {
        return $this->hasOne(TblMaklumbalasPtj::className(), ['id_rekod' => 'id_rekod']);
    }
    
    
    
        public static function totalPendingTaskPenyelia($icno) {

      
        $total = 0;
        if(TblMaklumbalasPtj::find()->where(['icno'=> $icno])->exists()){
       
            return '';
        
        }else{
             
               $total = count($model = TblTindakan::find()->where(['penyelia' => $icno])->all());

        if ($total > 0) {
                return  $total;
            }
        else {
                return '';
        }
     }
        
        
        
    
   }
    
}
