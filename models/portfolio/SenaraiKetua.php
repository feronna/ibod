<?php

namespace app\models\portfolio;

use Yii;

/**
 * This is the model class for table "hrm.portfolio_tbl_list_chief".
 *
 * @property int $id
 * @property string $icno
 * @property int $jabatan_id
 * @property string $created_dt
 * @property string $chief
 * @property string $section
 * @property string $details
 * @property int $level
 * @property int $level_p
 */
class SenaraiKetua extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.portfolio_tbl_list_chief';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jabatan_id', 'level_ketua', 'level_p','section_ketua'], 'integer'],
            [['created_dt', 'update_by'], 'safe'],
            [['icno', 'chief'], 'string', 'max' => 12],
            [['section', 'details'], 'string', 'max' => 255],
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
            'jabatan_id' => 'Jabatan ID',
            'created_dt' => 'Created Dt',
            'chief' => 'Chief',
            'section' => 'Section',
            'details' => 'Details',
            'level' => 'Level',
            'level_p' => 'Level P',
        ];
    }
    
     public function getKetua() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
//         public function getKakitangan() {
//        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'icno']);
//    }
    
      public function getSeksyenKetua() {
        return $this->hasOne(\app\models\portfolio\RefSection::className(), ['id' => 'section_ketua']);
    }
    
        public function getPekerjaNm2() {
        $kon = \app\models\portfolio\TblCartaJabatan::findOne(['parent'=> $this->icno]);
        
        return $this->icno . ''. '( ' . $kon->level_ketua . ' )';
    }
    
  
    
}
