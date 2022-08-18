<?php

namespace app\models\portfolio;

use Yii;

/**
 * This is the model class for table "hrm.portfolio_tbl_list_su".
 *
 * @property int $id
 * @property string $icno
 * @property int $jabatan_id
 * @property string $created_dt
 * @property string $chief
 * @property string $section
 * @property string $details
 * @property int $level_ketua
 * @property int $section_ketua
 * @property string $tugasan
 * @property string $update_by
 */
class TblListSu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.portfolio_tbl_list_su';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jabatan_id', 'level_su', 'section_su'], 'integer'],
            [['created_dt'], 'safe'],
            [['tugasan'], 'string'],
            [['icno', 'chief'], 'string', 'max' => 12],
            [['section', 'details'], 'string', 'max' => 255],
            [['update_by'], 'string', 'max' => 15],
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
            'level_ketua' => 'Level Ketua',
            'section_ketua' => 'Section Ketua',
            'tugasan' => 'Tugasan',
            'update_by' => 'Update By',
        ];
    }
    
         public function getKakitangan() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
         public function getKetua() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
       public function getSeksyenKetua() {
        return $this->hasOne(\app\models\portfolio\RefSection::className(), ['id' => 'section_su']);
    }
    
}
