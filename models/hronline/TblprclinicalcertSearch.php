<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblprclinicalcert;

class TblprclinicalcertSearch extends Tblprclinicalcert
{
    public function rules()
    {
        return [
            [['icno', 'type', 'title', 'dateAwd', 'certNo','startDt','endDt','awardBy','isVerified'], 'safe'],
            [['id'], 'integer'],
        ];
    }

   
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Tblprclinicalcert::find()->where(['isVerified'=>0]);

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
            'type' => $this->type,
            'isVerified' => $this->isVerified,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'certNo', $this->certNo]);

        return $dataProvider;
    }
}
