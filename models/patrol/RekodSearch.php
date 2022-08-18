<?php

namespace app\models\patrol;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\patrol\Rekod;
use Yii;
use yii\helpers\VarDumper;
/**
 * RekodSearch represents the model behind the search form of `app\models\patrol\Rekod`.
 */
class RekodSearch extends Rekod
{

    // public $year;
    // public $month;
    public $nama;
    public $date;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'route_id', 'bit_id'], 'integer'],
            [['icno', 'scan_date', 'latlng','nama','date'], 'safe'],
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
        $query = Rekod::find()->joinWith(['peronda'])->orderBy([
            'scan_date' => SORT_ASC,
          ]);

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

        if (!empty($this->nama)) {

            $query->andFilterWhere(['LIKE', 'hronline.tblprcobiodata.ICNO', $this->nama]);
        }
        $date = Yii::$app->getRequest()->getQueryParam('date');
        if (!empty($date)) {
            $query->andFilterWhere(['like', 'scan_date', $date]);
        }
        else{
            
            $query->andFilterWhere(['like', 'scan_date', date('Y-m-d')]);

        }

        return $dataProvider;
    }
    //[peronda sendiri]
    public function searchs($params)
    {
        $query = Rekod::find()->joinWith(['peronda'])->orderBy([
            'route_id' => SORT_DESC,
          ]);

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
        $id = Yii::$app->user->getId();

        $date = Yii::$app->getRequest()->getQueryParam('date');
        $query->andFilterWhere(['=', 'hronline.tblprcobiodata.ICNO', $id]);
        if (!empty($date)) {
            $query->andFilterWhere(['like', 'scan_date', $date]);
        }
        else{
            $query->andFilterWhere(['like', 'scan_date', date('Y-m-d')]);

        }
        // $query->andFilterWhere(['like', 'icno', $this->icno])
        //     ->andFilterWhere(['like', 'lat', $this->lat])
        //     ->andFilterWhere(['like', 'lng', $this->lng]);

        return $dataProvider;
    }
}
