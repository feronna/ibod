<?php

namespace app\models\klinikpanel;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\klinikpanel\Tblvisit;

/**
 * TblvisitSearch represents the model behind the search form of `app\models\klinikpanel\Tblvisit`.
 */
class TblvisitSearch extends Tblvisit
{
    // add the function below:

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rawatan_id', 'visit_klinik_id', 'mc_status', 'id_max_tuntutan', 'id_visit_status', 'id_kehadiran', 'tblvisit_batch_id', 'visit_diagnosis_id'], 'integer'],
            [['rawatan_date', 'visit_icno', 'pesakit_icno', 'pesakit_name', 'rawatan', 'date_created', 'tblvisit_catatan', 'bil_log'], 'safe'],
            [['jum_tuntutan', 'id_konsultasi'], 'number'],
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
        $query = Tblvisit::find()->where(['<>','id_visit_status',0])->orderBy(['rawatan_date'=>SORT_DESC]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'rawatan_id' => $this->rawatan_id,
            'visit_klinik_id' => $this->visit_klinik_id,
            'rawatan_date' => $this->rawatan_date,
            'mc_status' => $this->mc_status,
            'id_max_tuntutan' => $this->id_max_tuntutan,
            'jum_tuntutan' => $this->jum_tuntutan,
            'id_visit_status' => $this->id_visit_status,
            'date_created' => $this->date_created,
            'id_konsultasi' => $this->id_konsultasi,
            'id_kehadiran' => $this->id_kehadiran,
            'tblvisit_batch_id' => $this->tblvisit_batch_id,
            'visit_diagnosis_id' => $this->visit_diagnosis_id,
        ]);

        $query->andFilterWhere(['like', 'visit_icno', $this->visit_icno])
            ->andFilterWhere(['like', 'pesakit_icno', $this->pesakit_icno])
            ->andFilterWhere(['like', 'pesakit_name', $this->pesakit_name])
            ->andFilterWhere(['like', 'rawatan', $this->rawatan])
            ->andFilterWhere(['like', 'tblvisit_catatan', $this->tblvisit_catatan])
            ->andFilterWhere(['like', 'bil_log', $this->bil_log]);

        return $dataProvider;
    }
}
