<?php

namespace app\models\elnpt;

use Yii;

use app\models\elnpt\GredJawatan;
use app\models\elnpt\RefKumpGred;

/**
 * This is the model class for table "hrm.elnpt_tbl_kump_gred".
 *
 * @property int $id
 * @property int $ref_kump_gred_id
 * @property int $gred_id
 */
class TblKumpGred extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_tbl_kump_gred';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ref_kump_gred_id', 'gred_id'], 'required'],
            [['ref_kump_gred_id', 'gred_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ref_kump_gred_id' => 'Ref Kump Gred ID',
            'gred_id' => 'Gred ID',
        ];
    }
    
    public function getGred() {
        return $this->hasOne(GredJawatan::className(), ['id' => 'gred_id']);
    }
    
    public function getNamaKumpGred() {
        return $this->hasOne(RefKumpGred::className(), ['id' => 'ref_kump_gred_id']);
    }
    
}
