<?php

namespace app\models\ptb;
use app\models\hronline\Tblprcobiodata;

use Yii;

/**
 * This is the model class for table "ptb.tbl_admin".
 *
 * @property int $id
 * @property string $icno
 */
class TblAdmin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.ptb_tbl_admin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno'], 'string', 'max' => 200],
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
        ];
    }
    
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
    public function getPelulus(){
        return $this->hasOne(Recommendation::className(), ['application_id' => 'id'])->where(['type' => 3]);
           
    }
}
