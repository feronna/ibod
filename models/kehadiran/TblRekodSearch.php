<?php

namespace app\models\kehadiran;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\kehadiran\TblRekod;

/**
 * TblRekodSearch represents the model behind the search form of `app\models\TblRekod`.
 */
class TblRekodSearch extends TblRekod
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'reason_id', 'wp_id'], 'integer'],
            [['icno', 'day', 'tarikh', 'time_in', 'time_out', 'total_hours', 'remark', 'app_by', 'app_dt', 'remark_status', 'in_lat_lng', 'out_lat_lng', 'in_ip', 'out_ip'], 'safe'],
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
        //        $icno = Yii::$app->user->getId();

        $query = TblRekod::find();
        $query->joinWith(['kakitangan']);
        $query->limit(100);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
                        $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            //            'id' => $this->id,
            //            'tarikh' => $this->tarikh,
        ]);

        $query->andFilterWhere(['=', 'tarikh', $this->tarikh])
            ->andFilterWhere(['=', 'day', $this->day])
            ->andFilterWhere(['like', 'tblprcobiodata.CONm', $this->icno]);
        
        $query->orderBy(['tarikh' => SORT_ASC]);

        return $dataProvider;
    }
}
