<?php

namespace app\models\pengesahan;

use Yii;

/**
 * This is the model class for table "pengesahan.tbl_maklumatlain".
 *
 * @property int $id
 * @property int $pengesahan_id
 * @property int $jurnal
 * @property int $jurnal_international
 * @property int $jurnal_national
 * @property int $prosiding_international
 * @property int $prosiding_national
 * @property int $penulis_utama
 * @property int $penulis_utama2

 */
class TblMaklumatlain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
//        return 'pengesahan.tbl_maklumatlain';
        return 'hrm.sah_tbl_maklumatlain';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pengesahan_id', 'jurnal_international', 'jurnal_national', 'prosiding_international', 'prosiding_national', 'penulis_utama_jurnal_international', 'penulis_utama_jurnal_national', 'penulis_utama_prosiding_international', 'penulis_utama_prosiding_national'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pengesahan_id' => 'Pengesahan ID',
            'jurnal_international' => 'Jurnal International',
            'jurnal_national' => 'Jurnal National',
            'prosiding_international' => 'Prosiding International',
            'prosiding_national' => 'Prosiding National',
            'penulis_utama_jurnal_international' => 'Penulis Utama Jurnal International',
            'penulis_utama_jurnal_national' => 'Penulis Utama Jurnal National',
            'penulis_utama_prosiding_international' => 'Penulis Utama Prosiding International',
            'penulis_utama_prosiding_national' => 'Penulis Utama Prosiding National'
        ];
    }
}
