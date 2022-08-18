<?php

namespace app\models\myidp;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\myidp\Kehadiran;

/**
 * KehadiranSearch represents the model behind the search form of `app\models\myidp\Kehadiran`.
 */
class KehadiranSearch extends Kehadiran
{
    /**
     * {@inheritdoc}
     */
    
    public $CONm;
    public $DeptId;
    
    public function rules()
    {
        return [
            [['slotID'], 'integer'],
            [['staffID', 'statusPeserta'], 'safe'],
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
        //$query = Kehadiran::find();
        //$query = Kehadiran::find()->where(['slotID' => $params])->indexBy('slotID'); original
        $query = Kehadiran::find()
                ->joinWith('peserta')
                ->where(['slotID' => $params['slotID']])
                ->orderBy(['tarikhMasa' => SORT_DESC]);

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
            'DeptId' => $this->DeptId,
        ]);

        $query->andFilterWhere(['like', 'staffID', $this->staffID])
            ->andFilterWhere(['like', 'statusPeserta', $this->statusPeserta])
            ->andFilterWhere(['like', 'CONm', $this->CONm]);

        return $dataProvider;
    }
}
