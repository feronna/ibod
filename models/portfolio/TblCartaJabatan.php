<?php

namespace app\models\portfolio;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Adminposition;
use Yii;

/**
 * This is the model class for table "hrm.portfolio_tbl_carta_jabatan".
 *
 * @property int $id
 * @property string $icno
 * @property string $level
 * @property string $section
 * @property string $unit
 */
class TblCartaJabatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.portfolio_tbl_carta_jabatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno','level_ketua','level_staff','parent'], 'string', 'max' => 15],
            [['tugasan','unit_ketua', 'unit', 'unit_staff','section_staff', 'section_ketua'], 'string', 'max' => 255],

            [['level', 'section', 'parent_section','isSU'], 'string', 'max' => 5],
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
            'level' => 'Level',
            'section' => 'Section',
            'unit' => 'Unit',
        ];
    }
    
       public function getKakitangan() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
        public function getKakitanganParents() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'parent']);
    }
    
    
    public static function getStaf($gred, $holder_icno = null, $dept_id=null, $program_id=null)
    {

        $model = Tblprcobiodata::find()->joinWith('jawatan')
            ->where(['Status' => 1, 'gred' => $gred, 'statLantikan' => 1])
            ->andFilterWhere(['!=', 'ICNO', $holder_icno])
            ->andFilterWhere(['deptId' => $dept_id, 'KodProgram' => $program_id])
            ->orderBy(['endDateLantik' => SORT_ASC])
            ->all();

        if ($model) {
            return $model;
        }

        return false;
    }
    
          public function getNamaUnit() {
        return $this->hasOne(\app\models\portfolio\RefUnit::className(), ['id' => 'unit_staff']);
    }
        public function getNamaSeksyen() {
        return $this->hasOne(\app\models\portfolio\RefSection::className(), ['id' => 'section']);
    }
    public function getKetua() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'parent']);
    }
       public function getSeksyenKetua() {
        return $this->hasOne(\app\models\portfolio\RefSection::className(), ['id' => 'section_ketua']);
       }
        public function getUnitKetua() {
        return $this->hasOne(\app\models\portfolio\RefUnit::className(), ['id' => 'unit_ketua']);
    }
       
         public function getMyjd() {
        return $this->hasOne(\app\models\myportfolio\TblPortfolio::className(), ['jabatan_semasa' => 'jabatan_id']);
    }
    
        public function getSeksyenStaf() {
        return $this->hasOne(\app\models\portfolio\RefSection::className(), ['id' => 'section']);
       }
       
        public function getUnitStaf() {
        return $this->hasOne(\app\models\portfolio\RefUnit::className(), ['id' => 'unit_staff']);
    }
             public function getRefPeringkat() {
        return $this->hasOne(RefPeringkat::className(), ['id' => 'level_staff']);
    }
      public function getRefPeringkat2() {
        return $this->hasOne(RefPeringkat::className(), ['id' => 'level_ketua']);
    }
    
         public function getCartaSection()
    {
          $icno=Yii::$app->user->getId();
        return $this->hasOne(TblCartaJabatan::className(), ['section' => 'section_id'])->andWhere(['icno' => $icno]);
    }
    
        
      public function getCartaUnit()
    {
          $icno=Yii::$app->user->getId();
        return $this->hasOne(TblCartaJabatan::className(), ['unit_staff' => 'id'])->andWhere(['icno' => $icno]);
    }
   
    
    
       

    


    
}
