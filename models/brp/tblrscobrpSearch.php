<?php

namespace app\models\brp;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\brp\tblrscobrp;
USE app\models\hronline\Tblprcobiodata;

/**
 * tblrscobrpSearch represents the model behind the search form of `app\models\brp\tblrscobrp`.
 */
class tblrscobrpSearch extends tblrscobrp
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['brp_id', 'jawatan_id', 'isPencen', 'status', 'sah', 't_lpg_id'], 'integer'],
            [['icno', 'brpCd', 'remark', 'tarikh_mulai', 'tarikh_hingga', 'tarikh_lulus', 'rujukan_surat', 'tarikh_surat', 'status_date', 'status_update_by', 'sah_date', 'sah_by', 'data_source', 'insert_date', 'insert_id', 'last_update', 'update_by'], 'safe'],
            [['gaji_sebulan'], 'number'],
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
    
     protected function findModel($id) {
        if (($model = Tblprcobiodata::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    
    public function search($params)
    {
       // $query = tblrscobrp::find();
       // $request = Yii::$app->request;
       // $id = $request->get('id');
      //  $model = Tblprcobiodata::findOne($id);
        $query = tblrscobrp::find()->where(['!=', 'status', 1]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        
        

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'brp_id' => $this->brp_id,
            'jawatan_id' => $this->jawatan_id,
            'tarikh_mulai' => $this->tarikh_mulai,
            'tarikh_hingga' => $this->tarikh_hingga,
            'tarikh_lulus' => $this->tarikh_lulus,
            'tarikh_surat' => $this->tarikh_surat,
            'isPencen' => $this->isPencen,
            'gaji_sebulan' => $this->gaji_sebulan,
            'status' => $this->status,
            'status_date' => $this->status_date,
            'sah' => $this->sah,
            'sah_date' => $this->sah_date,
            't_lpg_id' => $this->t_lpg_id,
            'insert_date' => $this->insert_date,
            'last_update' => $this->last_update,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'brpCd', $this->brpCd])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'rujukan_surat', $this->rujukan_surat])
            ->andFilterWhere(['like', 'status_update_by', $this->status_update_by])
            ->andFilterWhere(['like', 'sah_by', $this->sah_by])
            ->andFilterWhere(['like', 'data_source', $this->data_source])
            ->andFilterWhere(['like', 'insert_id', $this->insert_id])
            ->andFilterWhere(['like', 'update_by', $this->update_by]);

        return $dataProvider;
  
    }
}
