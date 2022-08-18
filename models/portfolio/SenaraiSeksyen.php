<?php

namespace app\models\portfolio;
use app\models\portfolio\SenaraiKetua;

use Yii;

/**
 * This is the model class for table "hrm.portfolio_tbl_list_section".
 *
 * @property int $id
 * @property string $icno
 * @property int $jabatan_id
 * @property string $created_dt
 * @property string $details
 * @property string $section
 */
class SenaraiSeksyen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.portfolio_tbl_list_section';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jabatan_id','level','level_ketua','id', 'section_ketua'], 'integer'],
            [['created_dt'], 'safe'],
            [['icno','chief'], 'string', 'max' => 12],
            [['details', 'section'], 'string', 'max' => 255],
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
            'details' => 'Details',
            'section' => 'Section',
        ];
    }
       public function getKakitangan() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
       public function getKetua() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'chief']);
    }
    
      public function getSeksyenKetua() {
        return $this->hasOne(\app\models\portfolio\RefSection::className(), ['id' => 'section_ketua']);
    }
    
      public function getSeksyenStaf() {
        return $this->hasOne(\app\models\portfolio\RefSection::className(), ['id' => 'section']);
    }
    
    
 
}
