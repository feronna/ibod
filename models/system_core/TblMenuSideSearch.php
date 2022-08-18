<?php

namespace app\models\system_core;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\system_core\TblMenuSide;

/**
 * TblMenuSideSearch represents the model behind the search form of `app\models\system_core\TblMenuSide`.
 */
class TblMenuSideSearch extends TblMenuSide
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'order', 'icon_id', 'parent_id', 'status'], 'integer'],
            [['label', 'url', 'visible'], 'safe'],
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
        $query = TblMenuSide::find()->where(['parent_id' => null])->orderBy(['order' => SORT_ASC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ]
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
            'order' => $this->order,
            'icon_id' => $this->icon_id,
            'parent_id' => $this->parent_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'visible', $this->visible]);

        return $dataProvider;
    }
}
