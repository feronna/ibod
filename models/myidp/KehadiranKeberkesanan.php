<?php

namespace app\models\myidp;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\myidp\Kehadiran;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;

/**
 * KehadiranByJabatan represents the model behind the search form of `app\models\myidp\Kehadiran`.
 */
class KehadiranKeberkesanan extends Kehadiran
{
    /**
     * {@inheritdoc}
     */
    
    public $tajukLatihan;
    public $bulan;
    public $jenis;
    public $unitBertanggungjawab;
    
    public function rules()
    {
        return [
            [['slotID', 'kategoriKursusID'], 'integer'],
            [['staffID', 'statusPeserta', 'tarikhMasa'], 'safe'],
            [['tajukLatihan', 'bulan', 'jenis', 'unitBertanggungjawab'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params){

        $today = date('Y-m-d');
        
        $user = Yii::$app->user->getId();
        
        // $getJabatan = Tblprcobiodata::find()
        //         ->where(['ICNO' => $user])
        //         ->one();

        $check = Department::find()
                ->where(['chief' => $user, 'isActive' => '1'])
                ->orWhere(['pp' => $user, 'id' => '164', 'isActive' => '1']) //HUMS
                ->all();

        if ($check) {

            $senaraiSiri = [];

            foreach ($check as $c){

                // $modelSiri = Kehadiran::find()
                // ->joinWith('peserta')
                // ->joinWith('sasaran9.sasaran4.sasaran3')
                // ->where(['DeptId' => $c->id, 'YEAR(tarikhMula)' => date('Y'), 'jenisLatihanID' => 'latihanDalaman'])
                // ->andWhere(['kompetensi' => '6'])
                // ->groupBy('idp_slotLatihan.siriLatihanID')
                // ->orderBy(['tarikhMula' => SORT_DESC])
                // ->all();

                /** remove current year checking */
                $modelSiri = Kehadiran::find()
                ->joinWith('peserta')
                ->joinWith('sasaran9.sasaran4.sasaran3')
                ->where(['DeptId' => $c->id, 'jenisLatihanID' => 'latihanDalaman'])
                ->andWhere(['kompetensi' => '6'])
                ->groupBy('idp_slotLatihan.siriLatihanID')
                ->orderBy(['tarikhMula' => SORT_DESC])
                ->all();

                foreach ($modelSiri as $modelSiri){
            
                    $dateSiri = date_create($modelSiri->sasaran9->sasaran4->tarikhMula);
                    $dateBefore = date_add($dateSiri,date_interval_create_from_date_string("6 months"));
                    $dateBefore2 = date_format($dateBefore, "Y-m-d");

                    if ($dateBefore2 <= $today){
                        array_push($senaraiSiri, $modelSiri->sasaran9->siriLatihanID);

                    }
                }

                $query = Kehadiran::find()
                ->joinWith('peserta')
                ->joinWith('sasaran9.sasaran4.sasaran3')
                ->where(['DeptId' => $c->id])
                ->andWhere(['idp_slotLatihan.siriLatihanID' => $senaraiSiri])
                ->groupBy('idp_slotLatihan.siriLatihanID')
                ->orderBy(['tarikhMula' => SORT_DESC]);

                // add conditions that should always apply here

                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                ]);

                $this->load($params);

                if (!$this->validate()) {
                    // uncomment the following line if you do not want to return any records when validation fails
                    // $query->where('0=1');
                    return $dataProvider;
                }

                // grid filtering conditions
                $query->andFilterWhere([
                    'slotID' => $this->slotID,
                    'tarikhMasa' => $this->tarikhMasa,
                    'kategoriKursusID' => $this->kategoriKursusID,
                    'MONTH(tarikhMula)' => $this->bulan,
                    'idp_kursusLatihan.jenisLatihanID' => $this->jenis,
                    'idp_kursusLatihan.unitBertanggungjawab' => $this->unitBertanggungjawab,
                ]);

                $query->andFilterWhere(['like', 'staffID', $this->staffID])
                    ->andFilterWhere(['like', 'statusPeserta', $this->statusPeserta])
                    ->andFilterWhere(['like', 'tajukLatihan', $this->tajukLatihan]);

                return $dataProvider;
            }

            




        }

        

        

        

        
    }
}
