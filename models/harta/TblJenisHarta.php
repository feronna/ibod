<?php

namespace app\models\harta;

use Yii;

/**
 * This is the model class for table "harta.tbl_jenis_harta".
 *
 * @property string $hartaCd
 * @property string $jenis_harta
 */
class TblJenisHarta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.harta_tbl_jenis_harta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hartaCd'], 'string', 'max' => 3],
            [['jenis_harta'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'hartaCd' => 'Harta Cd',
            'jenis_harta' => 'Jenis Harta',
        ];
    }
    
     public function getSenarai() {
        return $this->hasMany(TblSenarai::className(), ['hartaCd'=>'hartaCd']);
    }
} 
