<?php

namespace app\models\myidp;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\myidp\PermohonanMataIdpIndividu;

/**
 * PermohonanMataIdpSearch represents the model behind the search form of `app\models\myidp\PermohonanMataIdpIndividu`.
 */
class PermohonanMataIdpSearch extends PermohonanMataIdpIndividu
{
    /**
     * {@inheritdoc}
     */
    public $CONm;
    public $CONm2;
    public $CONm3;
    public $DeptId;
    public $DeptId2;
    public $DeptId3;
    public $program;
    public $program2;
    public $program3;
    
    public function rules()
    {
        return [
            [['permohonanID', 'mataIDPlulus', 'kompetensiCadangan', 'kompetensiLulus', 'mataIDPcadangan', 'kompetensiPohon'], 'integer'],
            [['pemohonID', 'namaProgram', 'jenisPenganjur', 'namaPenganjur', 'tarikhTamat', 'tarikhMula', 'lokasi', 'statusPermohonan', 'diluluskanOleh', 'tarikhBatalPermohonan', 'failProgram1', 'failProgram2', 'failProgram3', 'tarikhKelulusan', 'statusKJ', 'tarikhSemakanKJ', 'ulasanKJ', 'kjPenyemak', 'statusBSM', 'tarikhSemakanBSM', 'ulasanBSM', 'disemakOleh', 'tarikhPohon', 'laporan', 'statusUL', 'adminUL', 'tarikhSemakanUL', 'justifikasiBatal', 'dibatalkanOleh', 'statusSektor', 'ulasanSektor', 'jenisPermohonan'], 'safe'],
            [['CONm', 'CONm2', 'CONm3', 'DeptId', 'DeptId2', 'DeptId3', 'program', 'program2', 'program3'], 'safe'],
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
    public function search($params)
    {
        $query = PermohonanMataIdpIndividu::find()
                ->joinWith('biodata.jawatan')
                ->orderBy(['tarikhPohon' => SORT_ASC]);

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
            'permohonanID' => $this->permohonanID,
            'tarikhTamat' => $this->tarikhTamat,
            'tarikhMula' => $this->tarikhMula,
            'tarikhBatalPermohonan' => $this->tarikhBatalPermohonan,
            'mataIDPlulus' => $this->mataIDPlulus,
            'tarikhKelulusan' => $this->tarikhKelulusan,
            'tarikhSemakanKJ' => $this->tarikhSemakanKJ,
            'tarikhSemakanBSM' => $this->tarikhSemakanBSM,
            'kompetensiCadangan' => $this->kompetensiCadangan,
            'tarikhPohon' => $this->tarikhPohon,
            'kompetensiLulus' => $this->kompetensiLulus,
            'mataIDPcadangan' => $this->mataIDPcadangan,
            'kompetensiPohon' => $this->kompetensiPohon,
            'tarikhSemakanUL' => $this->tarikhSemakanUL,
            'DeptId' => $this->DeptId,
            'DeptId' => $this->DeptId2,
            'DeptId' => $this->DeptId3,
        ]);

        $query->andFilterWhere(['like', 'pemohonID', $this->pemohonID])
            ->andFilterWhere(['like', 'namaProgram', $this->namaProgram])
            ->andFilterWhere(['like', 'jenisPenganjur', $this->jenisPenganjur])
            ->andFilterWhere(['like', 'namaPenganjur', $this->namaPenganjur])
            ->andFilterWhere(['like', 'lokasi', $this->lokasi])
            ->andFilterWhere(['like', 'diluluskanOleh', $this->diluluskanOleh])
            ->andFilterWhere(['like', 'failProgram1', $this->failProgram1])
            ->andFilterWhere(['like', 'failProgram2', $this->failProgram2])
            ->andFilterWhere(['like', 'failProgram3', $this->failProgram3])
            ->andFilterWhere(['like', 'statusKJ', $this->statusKJ])
            ->andFilterWhere(['like', 'ulasanKJ', $this->ulasanKJ])
            ->andFilterWhere(['like', 'kjPenyemak', $this->kjPenyemak])
            ->andFilterWhere(['like', 'statusBSM', $this->statusBSM])
            ->andFilterWhere(['like', 'ulasanBSM', $this->ulasanBSM])
            ->andFilterWhere(['like', 'disemakOleh', $this->disemakOleh])
            ->andFilterWhere(['like', 'laporan', $this->laporan])
            ->andFilterWhere(['like', 'statusUL', $this->statusUL])
            ->andFilterWhere(['like', 'adminUL', $this->adminUL])
            ->andFilterWhere(['like', 'justifikasiBatal', $this->justifikasiBatal])
            ->andFilterWhere(['like', 'dibatalkanOleh', $this->dibatalkanOleh])
            ->andFilterWhere(['like', 'statusSektor', $this->statusSektor])
            ->andFilterWhere(['like', 'ulasanSektor', $this->ulasanSektor])
            ->andFilterWhere(['like', 'jenisPermohonan', $this->jenisPermohonan])
            ->andFilterWhere(['like', 'pemohonID', $this->CONm])
            ->andFilterWhere(['like', 'pemohonID', $this->CONm2])
            ->andFilterWhere(['like', 'pemohonID', $this->CONm3])
            ->andFilterWhere(['like', 'namaProgram', $this->program])
            ->andFilterWhere(['like', 'namaProgram', $this->program2])
            ->andFilterWhere(['like', 'namaProgram', $this->program3]);
        
        if ($this->statusPermohonan == '3'){
            $dataProvider->query->andFilterWhere(['=', 'statusPermohonan', [$this->statusPermohonan, '33']]);    
        } elseif ($this->statusPermohonan == '4'){
            $dataProvider->query->andFilterWhere(['=', 'statusPermohonan', [$this->statusPermohonan]]);    
        } elseif ($this->statusPermohonan == '5'){
            $dataProvider->query->andFilterWhere(['like', 'statusSektor', ['5']]);    
        } elseif ($this->statusPermohonan == '6'){
            $dataProvider->query->andFilterWhere(['like', 'statusSektor', ['4']]);    
        }

        return $dataProvider;
    }
}
