<?php

namespace app\models\portfolio;

use Yii;

/**
 * This is the model class for table "hrm.portfolio_ref_section".
 *
 * @property int $id
 * @property int $jabatan_id
 * @property string $section_details
 */
class RefSection extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.portfolio_ref_section';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jabatan_id'], 'integer'],
            [['section_details'], 'string', 'max' => 500],
                        [['icno'], 'string', 'max' => 12],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jabatan_id' => 'Jabatan ID',
            'section_details' => 'Section Details',
        ];
    }
     public function getKakitangan() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
      public function getCartaJabatan() {
        return $this->hasOne(TblCartaJabatan::className(), ['section' => 'id']);
    }
}
