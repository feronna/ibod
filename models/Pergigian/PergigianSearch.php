<?php

namespace app\models\Pergigian;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pergigian\Pergigian;

/**
 * PergigianSearch represents the model behind the search form of `app\models\Pergigian\Pergigian`.
 */
class PergigianSearch extends Pergigian
{
    /**
     * {@inheritdoc}
     */
    public $name;
    
    
    public function rules()
    {
        return [
            [['tuntutan_gigi_id', 'klinik_gigi_id', 'gred_id', 'dept_id'], 'integer'],
            [['icno', 'used_dt', 'check_by', 'check_dt', 'app_by', 'app_dt', 'jumlah_tuntutan', 'catatan', 'entry_dt'], 'safe'],
            [['name'], 'safe'],
            
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
        $query = Pergigian::find()
                ->joinWith('kakitangan')
                ->orderBy(['used_dt' => SORT_DESC]);

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
            'tuntutan_gigi_id' => $this->tuntutan_gigi_id,
            'klinik_gigi_id' => $this->klinik_gigi_id,
            'gred_id' => $this->gred_id,
            'dept_id' => $this->dept_id,
            'used_dt' => $this->used_dt,
            'check_dt' => $this->check_dt,
            'app_dt' => $this->app_dt,
            'entry_dt' => $this->entry_dt,
            'kakitangan.CONm' => $this->icno,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'check_by', $this->check_by])
            ->andFilterWhere(['like', 'app_by', $this->app_by])
            ->andFilterWhere(['like', 'jumlah_tuntutan', $this->jumlah_tuntutan])
            ->andFilterWhere(['like', 'catatan', $this->catatan])
            ->andFilterWhere(['like', 'hronline.tblprcobiodata.CONm',$this->name]);

        return $dataProvider;
    }
}
