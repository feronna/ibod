<?php

namespace app\models\myportfolio;

use Yii;

/**
 * This is the model class for table "myportfolio.tbl_dimensi".
 *
 * @property int $id
 * @property string $icno
 * @property string $dimensi
 * @property string $dimensi_utama
 */
class TblDimensi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.myjd_tbl_dimensi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno'], 'string', 'max' => 12],
            [['dimensi', 'dimensi_utama'], 'string'],
            [['dimensi','dimensi_utama'], 'required','message' => Yii::t('app', 'Wajib Diisi')],
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
            'dimensi' => 'Dimensi',
            'dimensi_utama' => 'Dimensi Utama',
            'lain_lain' => 'lain'
        ];
    }
       public function getRefDimensi() {
        return $this->hasOne(RefDimensi::className(), ['id' => 'dimensi']);
    }
}
