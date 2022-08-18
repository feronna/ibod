<?php

namespace app\models\Keselamatan;

use app\models\hronline\Tblprcobiodata;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Keselamatan\TblTindakanBertulisLisan;

/**
 * TblTindakanLisanSearch represents the model behind the search form of `app\models\Keselamatan\TblTindakanBertulisLisan`.
 */
class TblTindakanLisanSearch extends TblTindakanBertulisLisan
{
    /**
     * {@inheritdoc}
     */
    public $arr;

    public function rules()
    {
        return [
            [['id', 't_bertulis', 't_lisan'], 'integer'],
            [['date','tahun', 'receiver_icno', 'sender_icno', 'date_entered', 'comment'], 'safe'],
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
    public function getKakitangan()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'receiver_icno']);
    }

    public function search($params)
    {
        $query = TblTindakanBertulisLisan::find();
        $query->joinWith(['kakitangan']);

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
        // $search = $params['TblTindakanLisanSearch']["receiver_icno"];
        // $icno = Tblprcobiodata::findOne(['like','CONm',$search]);
        // var_dump($i);die;
        // grid filtering conditions
        // $query->andFilterWhere([
        //     'id' => $this->id,
        //     't_bertulis' => $this->t_bertulis,
        //     't_lisan' => $this->t_lisan,
        //     'date' => $this->date,
        //     'date_entered' => $this->date_entered,
        // ]);

        $query
        // ->andFilterWhere(['like', 'receiver_icno', $this->receiver_icno])
            ->andFilterWhere(['like', 'sender_icno', $this->sender_icno])
            ->andFilterWhere(['like', 'comment', $this->comment]);
            // ->andFilterWhere(['like', 'tblprcobiodata.CONm', $this->receiver_icno]);
        if (!empty($this->receiver_icno)) {
            $query->andFilterWhere([
                'LIKE', 'tblprcobiodata.CONm', $this->receiver_icno,
            ]);
        }
        if (!empty($this->tahun)) {
            // var_dump($this->tahun);die;

            $query->andFilterWhere([
                'YEAR(date)' => $this->tahun,
            ]);
        }
        return $dataProvider;
    }
}
