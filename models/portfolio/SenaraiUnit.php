<?php

namespace app\models\portfolio;

use Yii;

/**
 * This is the model class for table "hrm.portfolio_tbl_list_unit".
 *
 * @property int $id
 * @property string $icno
 * @property int $jabatan_id
 * @property string $update_by
 * @property string $created_dt
 * @property string $details
 */
class SenaraiUnit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.portfolio_tbl_list_unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'jabatan_id','section','level','level_ketua', 'section_ketua', 'chief','unit_ketua'], 'integer'],
            [['created_dt'], 'safe'],
            [['icno', 'update_by'], 'string', 'max' => 12],
            [['unit'], 'string', 'max' => 255],
                        [['details'], 'string'],

            [['id'], 'unique'],
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
            'update_by' => 'Update By',
            'created_dt' => 'Created Dt',
            'details' => 'Details',
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
    
       public function getNamaUnit() {
        return $this->hasOne(\app\models\portfolio\RefUnit::className(), ['id' => 'unit']);
    }
    
     public function getUnitKetua() {
        return $this->hasOne(\app\models\portfolio\RefUnit::className(), ['id' => 'unit_ketua']);
    }
}
