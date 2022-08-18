<?php

namespace app\models\portfolio;

use Yii;
use app\models\portfolio\TblPeringkat;
use app\models\portfolio\RefSection;

/**
 * This is the model class for table "hrm.portfolio_tbl_senarai_peringkat".
 *
 * @property int $id
 * @property int $id_peringkat
 * @property string $icno
 * @property int $section_id
 */
class TblSenaraiPeringkat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.portfolio_tbl_senarai_peringkat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_peringkat', 'section_id'], 'integer'],
            [['icno'], 'string', 'max' => 15],
              [['unit_id'],'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_peringkat' => 'Id Peringkat',
            'icno' => 'Icno',
            'section_id' => 'Section ID',
        ];
    }
    
        public function getIdPeringkat() {
        return $this->hasOne(TblPeringkat::className(), ['id' => 'id_peringkat']);
    }
    
        public function getKakitangan() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
        public function getSection() {
        return $this->hasOne(RefSection::className(), ['id' => 'section_id']);
    }
       public function getUnit() {
        return $this->hasOne(RefUnit::className(), ['id' => 'unit_id']);
    }
    
        public function getPekerjaNm2() {
        if($this->section_id != null){ 
        return $this->nama. ' ' . '( ' . 'PERINGKAT - '. ' ' . $this->peringkat. ' )' .' '. '( ' . $this->section_details . ' )';
        }else{
        return $this->nama . ' ' . '( ' . 'PERINGKAT - '. ' ' . $this->peringkat. ' )' ." ". '( ' . $this->unit_details . ' )';
        }

    }
           public function getPekerjaNm3() {
        if($this->section_id != null){ 
        return $this->nama. ' ' . '( ' . 'PERINGKAT - '. ' ' . $this->peringkat. ' )' .' '. '( ' . $this->section_details . ' )';
        }else{
        return $this->nama . ' ' . '( ' . 'PERINGKAT - '. ' ' . $this->peringkat. ' )' ." ". '( ' . $this->unit_details . ' )';
        }

    }
    
        public function getRefPeringkat() {
        return $this->hasOne(RefPeringkat::className(), ['id' => 'peringkat']);
    }
  
}
