<?php

namespace app\models\myidp;

use Yii;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "{{%myidp.v_idp_kumpulan}}".
 *
 * @property string $vckl_kod_kumpulan
 * @property string $vckl_nama_kumpulan
 * @property int $kategori
 * @property int $susunan
 */
class VIdpKumpulan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrd.idp_v_idp_kumpulan}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vckl_kod_kumpulan'], 'required'],
            [['kategori', 'susunan'], 'integer'],
            [['vckl_kod_kumpulan'], 'string', 'max' => 50],
            [['vckl_nama_kumpulan'], 'string', 'max' => 100],
            [['vckl_kod_kumpulan'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'vckl_kod_kumpulan' => 'Vckl Kod Kumpulan',
            'vckl_nama_kumpulan' => 'Vckl Nama Kumpulan',
            'kategori' => 'Kategori',
            'susunan' => 'Susunan',
        ];
    }
    
//    public function countStaff($kumpulan, $category) { //not being used?
//        
//        $count = 0;
//        
//        if ($category == 0){ //keseluruhan
//            
//            $count = Tblprcobiodata::find()
//                    ->joinWith('jawatan')
//                    ->where(['<>', 'Status', '6'])
//                    ->andWhere(['cpd_group' => $kumpulan])
//                    ->count();
//            
//        } elseif ($category == 1) { //akademik
//            
//            $count = Tblprcobiodata::find()
//                    ->joinWith('jawatan')
//                    ->where(['<>', 'Status', '6'])
//                    ->andWhere(['cpd_group' => $kumpulan])
//                    ->andWhere(['job_category' => 1])
//                    ->count();
//            
//        } elseif ($category == 2){ //pentadbiran
//            
//            $count = Tblprcobiodata::find()
//                    ->joinWith('jawatan')
//                    ->where(['<>', 'Status', '6'])
//                    ->andWhere(['cpd_group' => $kumpulan])
//                    ->andWhere(['job_category' => 2])
//                    ->count();
//            
//        }
//        
//        return $count;
//        
//    }
}
