<?php

namespace app\models\guarantee_letter;

use Yii;

/**
 * This is the model class for table "guarantee_letter.tbl_klinik".
 *
 * @property int $id
 * @property string $name
 */
class TblHospital extends \yii\db\ActiveRecord
{ 
    public $searching;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.gl_tbl_hospital';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [  
            [['nama','daerah','searching'], 'string'], 
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Name',
        ];
    }
}
