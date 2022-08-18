<?php

namespace app\models\myidp;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\myidp\Kehadiran;
use app\models\hronline\Tblprcobiodata;

/**
 * KehadiranByJabatan represents the model behind the search form of `app\models\myidp\Kehadiran`.
 */
class KehadiranByJabatan extends Kehadiran
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
        
        $user = Yii::$app->user->getId();
        
        $getJabatan = Tblprcobiodata::find()
                ->where(['ICNO' => $user])
                ->one();
        
        $query = Kehadiran::find()
                ->joinWith('peserta')
                ->joinWith('sasaran9.sasaran4.sasaran3')
                ->where(['DeptId' => $getJabatan->DeptId])
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
