<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "idp.r_kategori".
 *
 * @property int $kategori_id
 * @property string $kategori_nama
 * @property string $asal
 */
class Kategori extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.idp_ref_kategori';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kategori_nama','kategori_nama_bi', 'asal'], 'string', 'max' => 50],
             [['academic', 'admin'],'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kategori_id' => 'Kategori ID',
            'kategori_nama' => 'Kategori Nama',
            'asal' => 'Asal',
        ];
    }
    
    public function getJenisKursus(){

            $a = "TIADA DATA";

            if ($this->kategori_id == 1){
                $a = '<span class="label label-default">UMUM</span>';    
            } elseif ($this->kategori_id == 3) {
                $a = '<span class="label label-danger">TERAS</span>';
            } elseif ($this->kategori_id == 4) {
                $a = '<span class="label label-primary">ELEKTIF</span>';
            } elseif ($this->kategori_id == 5) {
                $a = '<span class="label label-success">TERAS UNIVERSITI</span>';
            } elseif ($this->kategori_id == 6) {
                $a = '<span class="label label-success">TERAS SKIM</span>';
            } elseif ($this->kategori_id == 7) {
                $a = '<span class="label label-warning">IMPAK TINGGI</span>';
            }
            
            return $a;
   
    }
}
