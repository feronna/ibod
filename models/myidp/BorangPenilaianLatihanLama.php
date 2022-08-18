<?php

namespace app\models\myidp;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "idp.v_idp_penilaian_latihan_staf".
 *
 * @property string $pid
 * @property string $kursusId
 * @property string $pesertaId
 * @property string $tarikhIsi
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
 * @property string $insert_id
 * @property int $bsm_keyin 0=Staf Keyin,1=BSM Keyin
 * @property string $GenderCd Jantina
 * @property int $ApmtStatusCd Taraf Jawatan
 * @property int $DeptId JFPIU
 */
class BorangPenilaianLatihanLama extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'idp.v_idp_penilaian_latihan_staf';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kursusId', 'a1', 'a2', 'b1', 'b2', 'b3', 'b4', 'b5', 'c1', 'c2', 'c3', 'c4', 'c5', 'd1', 'd2', 'sblm1', 'sblm2', 'sblm3', 'sblm4', 'sblm5', 'sblm6', 'slps1', 'slps2', 'slps3', 'slps4', 'slps5', 'slps6', 'bsm_keyin', 'ApmtStatusCd', 'DeptId'], 'integer'],
            [['tarikhIsi'], 'safe'],
            [['a_ulasan', 'b_ulasan', 'c_ulasan', 'd_ulasan'], 'string'],
            [['pesertaId', 'insert_id'], 'string', 'max' => 12],
            [['GenderCd'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pid' => 'Pid',
            'kursusId' => 'Kursus ID',
            'pesertaId' => 'Peserta ID',
            'tarikhIsi' => 'Tarikh Isi',
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
            'insert_id' => 'Insert ID',
            'bsm_keyin' => 'Bsm Keyin',
            'GenderCd' => 'Gender Cd',
            'ApmtStatusCd' => 'Apmt Status Cd',
            'DeptId' => 'Dept ID',
        ];
    }
    
    public function CheckBorangStatusp($siriID, $pesertaID){
        
        $checkBorang = BorangPenilaianLatihanLama::find()
                ->where(['pesertaId' => $pesertaID])
                ->andWhere(['kursusId' => $siriID])
                ->one();
        
        if ($checkBorang){
//                return Html::a('<i class="fa fa-check" aria-hidden="true"></i>', 'borangpenilaianlatihan?id='.$siriID, [
//                                                          'title' => Yii::t('app', 'Papar Borang'),
//                                                          'data-pjax' => 0,
//                                                          'target' => "_blank",
//                                                          'class' => 'btn-sm btn-success btn-block text-center'
//                                                        ]);
                return Html::a('<i class="fa fa-check" aria-hidden="true"></i>', 'borangpenilaianlatihan?id='.$siriID.'&pesertaID='.$pesertaID.'&type=1', [
                                                          'title' => Yii::t('app', 'Papar Borang'),
                                                          'data-pjax' => 0,
                                                          'target' => "_blank",
                                                          'class' => 'btn-sm btn-success btn-block text-center'
                                                        ]);
        } else {
            return Html::button('<i class="fa fa-warning" aria-hidden="true"></i>', ['class' => 'btn-sm btn-danger btn-block', 'disabled' => true, 'title' => Yii::t('app', 'Borang penilaian latihan tidak diisi' )]);
        }
        
        //return $checkBorang->statusBorang;
        
    }
}
