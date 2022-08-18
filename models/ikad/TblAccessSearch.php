<?php

namespace app\models\ikad;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ikad\TblAccess;

/**
 * TblAccessSearch represents the model behind the search form of `app\models\ikad\TblAccess`.
 */
class TblAccessSearch extends TblAccess
{
    /**
     * {@inheritdoc}
     */
    public $name;

    public function rules()
    {
        return [
            [['id', 'accesstype', 'isActive'], 'integer'],
            [['ICNO','name'], 'safe'],
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
        $query = TblAccess::find()->joinWith(['kakitangan'])->where(['!=','accesstype','3']);
   

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
        // $query->andFilterWhere([
        //     'id' => $this->id,
        //     'accesstype' => $this->accesstype,
        //     'isActive' => $this->isActive,
        // ]);

        if (!empty($this->name)) {
            $query->andFilterWhere(['like', 'CONm', $this->name]);

        }
        if (!empty($this->isActive)) {
            // echo 'd';die;
            $query->andFilterWhere(['=', 'isActive', $this->isActive]);

        }
        return $dataProvider;
    }
}
