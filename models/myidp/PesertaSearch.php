<?php

namespace app\models\myidp;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\myidp\Peserta;

/**
 * PesertaSearch represents the model behind the search form of `app\models\myidp\Peserta`.
 */
class PesertaSearch extends Peserta
{
    /**
     * {@inheritdoc}
     */
    
    public $CONm;
    public $DeptId;
    
    public function rules()
    {
        return [
            [['permohonanID', 'statusKehadiran', 'kategoriKursusID', 'status', 'jumlahJamHadir', 'mataIDPcadangan', 'mataIDPlulus', 'kompetensiLulus'], 'integer'],
            [['staffID', 'statusUL', 'statusPL', 'statusKS'], 'safe'],
            [['CONm', 'DeptId'], 'safe'],
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
        $query = Peserta::find()
                ->joinWith('biodata.jawatan')
                ->where(['permohonanID' => $params]);

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
            'statusKehadiran' => $this->statusKehadiran,
            'kategoriKursusID' => $this->kategoriKursusID,
            'status' => $this->status,
            'jumlahJamHadir' => $this->jumlahJamHadir,
            'mataIDPcadangan' => $this->mataIDPcadangan,
            'mataIDPlulus' => $this->mataIDPlulus,
            'kompetensiLulus' => $this->kompetensiLulus,
            'DeptId' => $this->DeptId,
        ]);

        $query->andFilterWhere(['like', 'staffID', $this->staffID])
            ->andFilterWhere(['like', 'statusUL', $this->statusUL])
            ->andFilterWhere(['like', 'statusPL', $this->statusPL])
            ->andFilterWhere(['like', 'statusKS', $this->statusKS])
            ->andFilterWhere(['like', 'CONm', $this->CONm]);

        return $dataProvider;
    }
}
