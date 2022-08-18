<?php

namespace app\models\Pergigian;

use Yii;

/**
 * This is the model class for table "pergigian.tbl_klinik".
 *
 * @property int $klinik_gigi_id
 * @property string $klinik_nama
 * @property string $klinik_alamat
 * @property string $klinik_no_tel
 */
class Klinik extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    
    
    public static function tableName()
    {
        return 'hrm.gigi_tbl_klinik';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['klinik_alamat'], 'string'],
            [['klinik_nama'], 'string', 'max' => 255],
            [['klinik_no_tel'], 'string', 'max' => 100],
            [['lain'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'klinik_gigi_id' => 'Klinik Gigi ID',
            'klinik_nama' => 'Nama Klinik',
            'klinik_alamat' => 'Alamat',
            'klinik_no_tel' => 'No Telefon',
            'lain' => 'LAIN-LAIN',            
        ];
    }
}
