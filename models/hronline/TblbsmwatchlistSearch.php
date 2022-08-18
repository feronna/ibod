<?php

namespace app\models\hronline;

use yii\base\Model;
use Yii;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblbsmwatchlist;
use app\models\umsshield\Covid19Sample;

class TblbsmwatchlistSearch extends Tblbsmwatchlist
{

    public $sample_result;
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }

    public function rules()
    {
        return [
            [['icno', 'name','isAllowed','category', 'isDone','dateAD', 'dateDone','sample_result'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {   $array_1 = [];
        $array_2 = [];
        $array_3 = [];
        $query = Tblbsmwatchlist::find();

        $this->load($params);

        if($this->sample_result != null){
            switch ($this->sample_result) {
                case '0':
                    $wl = Tblbsmwatchlist::find()->select('icno')->where(['category'=>2])->asArray()->all();
                    foreach($wl as $wl){
                        array_push($array_1,$wl['icno']);
                    }
                    $sample= Covid19Sample::find()->select('icno')->asArray()->all();
                    foreach($sample as $sample){
                        array_push($array_2,$sample['icno']);
                    }
                    $array_3 = array_diff($array_1,$array_2);

                    $query->where(['IN','icno',$array_3]);

                    break;
                case 'Pending':
                    $sample= Covid19Sample::find()->select('icno')->where(['result'=>'Pending'])->asArray()->all();
                    foreach($sample as $sample){
                        array_push($array_2,$sample['icno']);
                    }
                    $query->where(['IN','icno',$array_2]);
                    break;
                case 'Detected':
                    $sample= Covid19Sample::find()->select('icno')->where(['result'=>'Detected'])->asArray()->all();
                    foreach($sample as $sample){
                        array_push($array_2,$sample['icno']);
                    }
                    $query->where(['IN','icno',$array_2]);
                    break;
                case 'Not Detected':
                    $sample= Covid19Sample::find()->select('icno')->where(['result'=>'Not Detected'])->asArray()->all();
                    foreach($sample as $sample){
                        array_push($array_2,$sample['icno']);
                    }
                    $query->where(['IN','icno',$array_2]);
                    break;
                
                default:
                    $query->where(['category'=>1]);
                    break;
            }
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'category' => $this->category,
            'isDone' => $this->isDone,
            'isAllowed' => $this->isAllowed,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
