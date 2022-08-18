<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblstatusvaksinasi;

class TblstatusvaksinasiSearch extends Tblstatusvaksinasi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status_vaksin','terima_dos1', 'terima_dos2'] ,'safe'],
            [['id','status_vaksin', 'terima_dos1', 'terima_dos2', 'sebab_belum_terima'], 'integer'],
            [['catatan'], 'string'],
            [['icno'], 'string', 'max' => 15],
            [['sijil_digital','lampiran'], 'string', 'max' => 255],
            [['file','lampiran'], 'safe'],
        ];
    }

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
        $query = Tblstatusvaksinasi::find();

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
            'id' => $this->id,
            'icno' => $this->icno,
            'sebab_belum_terima' => $this->sebab_belum_terima,
            'status_vaksin' => $this->status_vaksin,
        ]);

        return $dataProvider;
    }
}
