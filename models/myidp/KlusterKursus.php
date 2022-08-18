<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "idp.r_kluster_kursus".
 *
 * @property int $kluster_id
 * @property string $kluster_nama
 * @property int $kategori 1=Teras,2=Elektif
 * @property int $jobcategory 1=Akademik,2=Pentadbiran
 */
class KlusterKursus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.idp_ref_kluster_kursus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kategori', 'jobcategory'], 'integer'],
            [['kluster_nama'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kluster_id' => 'Kluster ID',
            'kluster_nama' => 'Kluster Nama',
            'kategori' => 'Kategori',
            'jobcategory' => 'Jobcategory',
        ];
    }

    public function getLongCatj() {
        if($this->jobcategory == 1){
            return 'AKADEMIK'; //untuk akademik
        }

        elseif($this->jobcategory == 2){
            return 'PENTADBIRAN'; //untuk pentadbiran
        }

        else {
            return '';
        }
    }

    public function getLongCatk() {
        if($this->kategori == 1){
            return 'TERAS'; //
        }

        elseif($this->kategori == 2){
            return 'ELEKTIF';
        }
        
        elseif($this->kategori == 5){
            return 'TERAS UNIVERSITI';
        }

        elseif($this->kategori == 6){
            return 'TERAS SKIM';
        }

        else {
            return '';
        }
    }
}
