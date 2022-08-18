<?php

namespace app\models\elnpt;

use Yii;
use yii\db\Expression;
use app\models\elnpt\RefPeratusKategori;
use app\models\elnpt\TblMrkhAspek;

/**
 * This is the model class for table "hrm.elnpt_tbl_mrkh_keseluruhan".
 *
 * @property string $id
 * @property string $lpp_id
 * @property double $markah
 * @property string $tarikh_kemaskini
 */
class TblMarkahKeseluruhan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_tbl_mrkh_keseluruhan';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
//    public static function getDb()
//    {
//        return Yii::$app->get('db2');
//    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_id'], 'integer'],
            [['markah', 'markah_ppp', 'markah_ppk', 'markah_peer'], 'number'],
            [['tarikh_kemaskini'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lpp_id' => 'Lpp ID',
            'markah' => 'Markah',
            'tarikh_kemaskini' => 'Tarikh Kemaskini',
        ];
    }
    
    public function getKategori($markah = null){
        $kategori = RefPeratusKategori::find()
                ->where(['<=', 'peratus_min', $markah ?? $this->markah])
                ->orderBy(['peratus_min' => SORT_DESC])
                ->one();
        
        return is_null($kategori) ? '' : $kategori->kategori;
    }
    
    public static function rankByDept($lppid, $jfpiu, $tahun){
        $rank = TblMarkahKeseluruhan::find()
                ->alias('a')
                ->select(new Expression('a.lpp_id, b.jfpiu, b.gred_jawatan_id, a.markah, '
                        . 'PERCENT_RANK() OVER (ORDER BY a.markah ASC) as percent'))
                ->leftJoin(['b' => 'hrm.elnpt_tbl_main'], 'a.`lpp_id` = b.`lpp_id`')
                ->where(['b.`tahun`' => $tahun, 'b.jfpiu' => $jfpiu])
                ->orderBy(['percent' => SORT_DESC]);
        
        $percent = (new \yii\db\Query())
                ->select('percent')
                ->from(['c' => $rank])
                ->where(['c.lpp_id' => $lppid])
                ->one();
        
//        $command = $percent->createCommand();
//
//        $rows = $command->queryAll();
        
        return empty($rank) ? [] : $percent['percent'] * 100;
    }
    
    public static function rankByGred($lppid, $jfpiu, $gred, $tahun){
        $rank = TblMarkahKeseluruhan::find()
                ->alias('a')
                ->select(new Expression('a.lpp_id, b.jfpiu, b.gred_jawatan_id, a.markah, '
                        . 'PERCENT_RANK() OVER (ORDER BY a.markah ASC) as percent'))
                ->leftJoin(['b' => 'hrm.elnpt_tbl_main'], 'a.`lpp_id` = b.`lpp_id`')
                ->where(['b.`tahun`' => $tahun, 'b.gred_jawatan_id' => $gred, 'b.jfpiu' => $jfpiu])
                ->orderBy(['percent' => SORT_DESC]);
        
        $percent = (new \yii\db\Query())
                ->select('percent')
                ->from(['c' => $rank])
                ->where(['c.lpp_id' => $lppid])
                ->one();
        
//        $command = $percent->createCommand();
//
//        $rows = $command->queryAll();
        
        return empty($rank) ? [] : $percent['percent'] * 100;
    }
    
    public static function rankAsWhole($lppid, $tahun){
        $rank = TblMarkahKeseluruhan::find()
                ->alias('a')
                ->select(new Expression('a.lpp_id, b.jfpiu, b.gred_jawatan_id, a.markah, '
                        . 'PERCENT_RANK() OVER (ORDER BY a.markah ASC) as percent'))
                ->leftJoin(['b' => 'hrm.elnpt_tbl_main'], 'a.`lpp_id` = b.`lpp_id`')
                ->where(['b.`tahun`' => $tahun])
                ->orderBy(['percent' => SORT_DESC]);
        
        $percent = (new \yii\db\Query())
                ->select('percent')
                ->from(['c' => $rank])
                ->where(['c.lpp_id' => $lppid])
                ->one();
        
//        $command = $percent->createCommand();
//
//        $rows = $command->queryAll();
        
        return empty($rank) ? [] : $percent['percent'] * 100;
    }
    
//    public function getSumMarkahPpp(){
//        return $this->hasMany(TblMrkhAspek::className(), ['lpp_id' => 'lpp_id'])->sum('markah_ppp');
//    }
//    
//    public function getSumMarkahPpk(){
//        return $this->hasMany(TblMrkhAspek::className(), ['lpp_id' => 'lpp_id'])->sum('markah_ppk');
//    }
//    
//    public function getSumMarkahPeer(){
//        return $this->hasMany(TblMrkhAspek::className(), ['lpp_id' => 'lpp_id'])->sum('markah_peer');
//    }
    
}
