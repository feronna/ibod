<?php

namespace app\models\guarantee_letter;

use Yii;

/**
 * This is the model class for table "guarantee_letter.tbl_kelas_wad".
 *
 * @property int $id
 * @property int $gred_no_min
 * @property int $gred_no_max
 * @property string $nama
 */
class TblKelasWad extends \yii\db\ActiveRecord
{ 
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.gl_tbl_kelas_wad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'gred_no_min', 'gred_no_max'], 'integer'],
            [['nama'], 'string', 'max' => 250],
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
            'gred_no_min' => 'Gred No Min',
            'gred_no_max' => 'Gred No Max',
            'nama' => 'Nama',
        ];
    }
}
