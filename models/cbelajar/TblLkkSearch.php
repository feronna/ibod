<?php

namespace app\models\cbelajar;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cbelajar\TblLkk;

/**
 * TbllkkSearch represents the model behind the search form of `app\models\cbelajar\TblLKK`.
 */
class TblLkkSearch extends TblLkk
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reportID', 'semester', 'session', 'modeID', 'no_ofdiscuss'], 'integer'],
            [['icno', 'report_fr', 'report_to', 'cw_gpa', 'cw_cgpa', 'dokumen_sokongan', 'ms_semester', 'reason_achieved', 'discussed_problem', 'research_problem', 'activity_sem', 'publications', 'completion_date', 'achievement_report', 'status_borang', 'tarikh_mohon', 'researchID', 'dokumen_sokongan2', 'sv_name', 'thesis_title', 'studentno'], 'safe'],
            [['ms_achieved'], 'number'],
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
        $query = TblLkk::find();

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
            'reportID' => $this->reportID,
            'semester' => $this->semester,
            'session' => $this->session,
            'report_fr' => $this->report_fr,
            'report_to' => $this->report_to,
            'modeID' => $this->modeID,
            'ms_achieved' => $this->ms_achieved,
            'no_ofdiscuss' => $this->no_ofdiscuss,
            'completion_date' => $this->completion_date,
            'tarikh_mohon' => $this->tarikh_mohon,
            'status_form' => $this->status_form,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'cw_gpa', $this->cw_gpa])
            ->andFilterWhere(['like', 'cw_cgpa', $this->cw_cgpa])
            ->andFilterWhere(['like', 'dokumen_sokongan', $this->dokumen_sokongan])
            ->andFilterWhere(['like', 'ms_semester', $this->ms_semester])
            ->andFilterWhere(['like', 'reason_achieved', $this->reason_achieved])
            ->andFilterWhere(['like', 'discussed_problem', $this->discussed_problem])
            ->andFilterWhere(['like', 'research_problem', $this->research_problem])
            ->andFilterWhere(['like', 'activity_sem', $this->activity_sem])
            ->andFilterWhere(['like', 'publications', $this->publications])
            ->andFilterWhere(['like', 'achievement_report', $this->achievement_report])
            ->andFilterWhere(['like', 'status_borang', $this->status_borang])
            ->andFilterWhere(['like', 'researchID', $this->researchID])
            ->andFilterWhere(['like', 'dokumen_sokongan2', $this->dokumen_sokongan2])
            ->andFilterWhere(['like', 'sv_name', $this->sv_name])
            ->andFilterWhere(['like', 'thesis_title', $this->thesis_title])
            ->andFilterWhere(['like', 'studentno', $this->studentno])
             ->andFilterWhere(['like', 'status_form', $this->status_form]);


        return $dataProvider;
    }
}
