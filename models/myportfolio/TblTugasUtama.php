<?php

namespace app\models\myportfolio;

use Yii;

use app\models\myportfolio\TblAkauntabiliti;

/**
 * This is the model class for table "myportfolio.tbl_tugas_utama".
 *
 * @property int $id
 * @property string $icno
 * @property string $tugas_utama
 * @property int $akauntabiliti_id
 */
class TblTugasUtama extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.myjd_tbl_tugas_utama';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['akauntabiliti_id'], 'integer'],
            [['icno'], 'string', 'max' => 12],
            [['description'], 'string'],
            [['description'], 'required','message' => Yii::t('app', 'Wajib Diisi')]
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
            'description' => 'Tugas Utama',
            'akauntabiliti_id' => 'Akauntabiliti ID',
        ];
    }
    
     public function getAkauntabiliti() {
        return $this->hasOne(TblAkauntabiliti::className(), ['id' => 'akauntabiliti_id']);
    }
    
  
}
