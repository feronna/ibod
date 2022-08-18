<?php

namespace app\models\myidp;

use Yii;
use app\models\hronline\Department;

/**
 * This is the model class for table "{{%myidp.kursusjemputan}}".
 *
 * @property int $jemputanID
 * @property int $siriLatihanID
 * @property int $deptID
 * @property int $jobCategory
 */
class KursusJemputan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrd.idp_kursusjemputan}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jemputanID', 'siriLatihanID', 'deptID', 'jobCategory', 'kategoriKursusID'], 'integer'],
            [['siriLatihanID', 'deptID', 'jobCategory'], 'unique', 'targetAttribute' => ['siriLatihanID', 'deptID', 'jobCategory']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'jemputanID' => Yii::t('app', 'Jemputan ID'),
            'siriLatihanID' => Yii::t('app', 'Siri Latihan ID'),
            'deptID' => Yii::t('app', 'Dept ID'),
            'jobCategory' => Yii::t('app', 'Job Category'),
            'kategoriKursusID' => Yii::t('app', 'Kategori Kursus ID'),
        ];
    }
    
    public function getJabatan(){
        
        return $this->hasOne(Department::className(), ['id' => 'deptID']);
                
    }
    
    public function getJobCategoryy(){
        
        if ($this->jobCategory == 1) {
            
            //return "PENTADBIRAN";
            return '<span class="label label-primary">AKADEMIK</span>'; 
            
        } elseif ($this->jobCategory == 2){
            
            //return "AKADEMIK";
            return '<span class="label label-danger">PENTADBIRAN</span>';
            
        } elseif ($this->jobCategory == 3) {
            
            //return "AKADEMIK & PENTADBIRAN";
            return '<span class="label label-success">AKADEMIK & PENTADBIRAN</span>';
            
        }
                
    }
    
    public function getKategoriKursus(){
        
        return $this->hasOne(Kategori::className(), ['kategori_id' => 'kategoriKursusID']);
    }
    
    public function getSiriKursus(){
        
        return $this->hasOne(SiriLatihan::className(), ['siriLatihanID' => 'siriLatihanID']);
    }
    
}
