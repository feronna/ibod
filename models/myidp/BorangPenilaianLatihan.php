<?php

namespace app\models\myidp;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "myidp.borangPenilaianLatihan".
 *
 * @property int $siriLatihanID
 * @property string $pesertaID
 * @property string $tarikhMasa
 * @property int $a1
 * @property int $a2
 * @property string $a_ulasan
 * @property int $b1
 * @property int $b2
 * @property int $b3
 * @property int $b4
 * @property int $b5
 * @property string $b_ulasan
 * @property int $c1
 * @property int $c2
 * @property int $c3
 * @property int $c4
 * @property int $c5
 * @property string $c_ulasan
 * @property int $d1
 * @property int $d2
 * @property string $d_ulasan
 * @property int $sblm1
 * @property int $sblm2
 * @property int $sblm3
 * @property int $sblm4
 * @property int $sblm5
 * @property int $sblm6
 * @property int $slps1
 * @property int $slps2
 * @property int $slps3
 * @property int $slps4
 * @property int $slps5
 * @property int $slps6
 */
class BorangPenilaianLatihan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.idp_tbl_bpl';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['siriLatihanID', 'pesertaID'], 'required'],
            [['siriLatihanID', 'a1', 'a2', 'b1', 'b2', 'b3', 'b4', 'b5', 'c1', 'c2', 'c3', 'c4', 'c5', 'd1', 'd2', 'sblm1', 'sblm2', 'sblm3', 'sblm4', 'sblm5', 'sblm6', 'slps1', 'slps2', 'slps3', 'slps4', 'slps5', 'slps6', 'statusBorang'], 'integer'],
            [['tarikhMasa'], 'safe'],
            [['a_ulasan', 'b_ulasan', 'c_ulasan', 'd_ulasan'], 'string'],
            [['pesertaID'], 'string', 'max' => 12],
            [['siriLatihanID', 'pesertaID'], 'unique', 'targetAttribute' => ['siriLatihanID', 'pesertaID']],
            
            [['a1', 'a2', 'b1', 'b2', 'b3', 'b4', 'b5', 'c1', 'c2', 'c3', 'c4', 'c5', 'd1', 'd2', 'sblm1', 'sblm2', 'sblm3', 'sblm4', 'sblm5', 'sblm6', 'slps1', 'slps2', 'slps3', 'slps4', 'slps5', 'slps6', 'a_ulasan', 'b_ulasan', 'c_ulasan', 'd_ulasan'], 
                'required', 'on' => 'bm',
                'message' => 'Sila isi ruangan ini.'
                ],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'siriLatihanID' => 'Kursus Latihan ID',
            'pesertaID' => 'Peserta ID',
            'tarikhMasa' => 'Tarikh Masa',
            'a1' => 'A1',
            'a2' => 'A2',
            'a_ulasan' => 'A Ulasan',
            'b1' => 'B1',
            'b2' => 'B2',
            'b3' => 'B3',
            'b4' => 'B4',
            'b5' => 'B5',
            'b_ulasan' => 'B Ulasan',
            'c1' => 'C1',
            'c2' => 'C2',
            'c3' => 'C3',
            'c4' => 'C4',
            'c5' => 'C5',
            'c_ulasan' => 'C Ulasan',
            'd1' => 'D1',
            'd2' => 'D2',
            'd_ulasan' => 'D Ulasan',
            'sblm1' => 'Sblm1',
            'sblm2' => 'Sblm2',
            'sblm3' => 'Sblm3',
            'sblm4' => 'Sblm4',
            'sblm5' => 'Sblm5',
            'sblm6' => 'Sblm6',
            'slps1' => 'Slps1',
            'slps2' => 'Slps2',
            'slps3' => 'Slps3',
            'slps4' => 'Slps4',
            'slps5' => 'Slps5',
            'slps6' => 'Slps6',
            'statusBorang' => 'Status Borang',
        ];
    }
    
    /** Relation **/
    public function getSasaran01(){
        return $this->hasOne(Umum::className(), ['staffID' => 'pesertaID']);
    }
    
    public function getSasaranSiriK(){
        return $this->hasOne(SiriLatihan::className(), ['siriLatihanID' => 'siriLatihanID']);
    }
    
    public function CheckBorangStatusp($siriID, $pesertaID){
        
        $checkBorang = BorangPenilaianLatihan::find()
                ->where(['pesertaID' => $pesertaID])
                ->andWhere(['siriLatihanID' => $siriID])
                ->one();
        
        if ($checkBorang && ($checkBorang->statusBorang == '2')){
//                return Html::a('<i class="fa fa-check" aria-hidden="true"></i>', 'borangpenilaianlatihan?id='.$siriID, [
//                                                          'title' => Yii::t('app', 'Papar Borang'),
//                                                          'data-pjax' => 0,
//                                                          'target' => "_blank",
//                                                          'class' => 'btn-sm btn-success btn-block text-center'
//                                                        ]);
                return Html::a('<i class="fa fa-check" aria-hidden="true"></i>', 'borangpenilaianlatihan?id='.$siriID.'&pesertaID='.$pesertaID.'&type=2', [
                                                          'title' => Yii::t('app', 'Papar Borang'),
                                                          'data-pjax' => 0,
                                                          'target' => "_blank",
                                                          'class' => 'btn-sm btn-success btn-block text-center'
                                                        ]);
        } elseif ($checkBorang && ($checkBorang->statusBorang == '1')) {
            return Html::button('<i class="fa fa-warning" aria-hidden="true"></i>', ['class' => 'btn-sm btn-danger btn-block', 'disabled' => true, 'title' => Yii::t('app', 'Borang penilaian latihan tidak diisi' )] );
        } else {
            return "";
        }
        
        //return $checkBorang->statusBorang;
        
    }
    
    public function CheckBorangStatuss($siriID){
        
        $checkBorang = BorangPenilaianLatihan::find()
                ->where(['pesertaID' => $this->pesertaID])
                ->andWhere(['siriLatihanID' => $siriID])
                ->one();
        
        return $checkBorang->statusBorang;
        
    }

    public function CheckBorangStatussk($siriID, $pesertaID){
        
        $checkBorang = BorangPenilaianLatihan::find()
                ->where(['pesertaID' => $pesertaID])
                ->andWhere(['siriLatihanID' => $siriID])
                ->one();
        
        return $checkBorang->statusBorang;
        
    }

    public static function calcPendingBorangd($userID){
        
        $currentYear = date('Y');
        
        $count = SiriLatihan::find()
                    ->joinWith('sasaran5.sasaran55')
                    ->joinWith('sasaranb')
                    ->where(['idp_kehadiran.staffID' => $userID])
                    ->andWhere(['<>', 'idp_kehadiran.kategoriKursusID',  1])
                    ->andWhere(['idp_tbl_bpl.pesertaID' => $userID, 'idp_tbl_bpl.statusBorang' => 1])
                    ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => $currentYear])
                    ->all();
        
//        $count = BorangPenilaianLatihan::find()
//                ->where(['pesertaID' => $userID, 'statusBorang' => 1])
//                ->all();
        
        if ($count) {
            return count($count);
        } else {
            return ' ';
        }
    }
    
    public function calcPendingBorang($userID){
        
        $currentYear = date('Y');
        
        $count = SiriLatihan::find()
                    ->joinWith('sasaran5.sasaran55')
                    ->joinWith('sasaranb')
                    ->where(['idp_kehadiran.staffID' => $userID])
                    ->andWhere(['<>', 'idp_kehadiran.kategoriKursusID',  1])
                    ->andWhere(['idp_tbl_bpl.pesertaID' => $userID, 'idp_tbl_bpl.statusBorang' => 1])
                    ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => $currentYear])
                    ->all();
        
//        $count = BorangPenilaianLatihan::find()
//                ->where(['pesertaID' => $userID, 'statusBorang' => 1])
//                ->all();
        
        if ($count) {
            return '&nbsp;<span class="badge bg-red">'.count($count).'</span>';
        } else {
            return ' ';
        }
    }
    
    public function calculateSudahIsi($siriID)
    {
        $countp = 0;
        
        $countp = BorangPenilaianLatihan::find()
                    ->where(['siriLatihanID' => $siriID])
                    ->andWhere(['statusBorang' => 2])
                    ->count();
        
        if ($countp > 0){
            //return '&nbsp;<span class="badge bg-green">'.$countp.'</span>';

            return Html::a($countp, 'laporan-kehadiran-siri?id='.$siriID, [
                'title' => Yii::t('app', 'Papar Borang'),
                'data-pjax' => 0,
                'target' => "_blank",
                'class' => 'btn-sm btn-info btn-block text-center'
              ]);

        } else {
            return "0";
        }
        
    }
    
    public function calculateBelumIsi($siriID)
    {
        $countpp = 0;
        
        $countpp = BorangPenilaianLatihan::find()
                    ->where(['siriLatihanID' => $siriID])
                    ->andWhere(['statusBorang' => 1])
                    ->count();
        
        if ($countpp > 0){
            return '&nbsp;<span class="badge bg-red">'.$countpp.'</span>';
        } else {
            return "0";
        }
        
    }
    
    public function calcPurataPenilaian($siriID, $section){
        
        $model = BorangPenilaianLatihan::find()
                    ->where(['siriLatihanID' => $siriID])
                    ->andWhere(['statusBorang' => 2])
                    ->all();
        
        $modelCount = BorangPenilaianLatihan::find()
                    ->where(['siriLatihanID' => $siriID])
                    ->andWhere(['statusBorang' => 2])
                    ->count();
        
        $total = 0;
        //section A
        if ($section == '1'){ 
            foreach ($model as $model){
                $total = $total + $model->a1 + $model->a2;
            }

            if ($modelCount != 0){
                return round(($total/($modelCount*2*4))*100);
            } else {
                return '0';
            }
        } elseif ($section == '2'){
            foreach ($model as $model){
                $total = $total + $model->b1 + $model->b2 + $model->b3 + $model->b4 + $model->b5;
            }

            if ($modelCount != 0){
                return round(($total/($modelCount*5*4))*100);
            } else {
                return '0';
            }
        } elseif ($section == '3'){
            foreach ($model as $model){
                $total = $total + $model->c1 + $model->c2 + $model->c3 + $model->c4 + $model->c5;
            }

            if ($modelCount != 0){
                return round(($total/($modelCount*5*4))*100);
            } else {
                return '0';
            }
        } elseif ($section == '4'){
            foreach ($model as $model){
                $total = $total + $model->d1 + $model->d2;
            }

            if ($modelCount != 0){
                return round(($total/($modelCount*2*4))*100);
            } else {
                return '0';
            }
        } elseif ($section == '5'){
            foreach ($model as $model){
                $total = $total + $model->sblm1 + $model->sblm2 + $model->sblm3 + $model->sblm4 + $model->sblm5 + $model->sblm6;
            }

            if ($modelCount != 0){
                return round(($total/($modelCount*6*4))*100);
            } else {
                return '0';
            }
        } elseif ($section == '6'){
            foreach ($model as $model){
                $total = $total + $model->slps1 + $model->slps2 + $model->slps3 + $model->slps4 + $model->slps5 + $model->slps6;
            }

            if ($modelCount != 0){
                return round(($total/($modelCount*6*4))*100);
            } else {
                return '0';
            }
        }
        
    }
}
