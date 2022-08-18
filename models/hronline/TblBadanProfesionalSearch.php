<?php

namespace app\models\hronline;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\TblBadanProfesional;

/**
 * TblBadanProfesionalSearch represents the model behind the search form of `app\models\hronline\TblBadanProfesional`.
 */
class TblBadanProfesionalSearch extends TblBadanProfesional
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
 
    public function rules()
    {
        return [
            [['profId', 'ProfAssocStatus'], 'integer'],
            [['ICNO', 'ProfBodyCd', 'ProfBodyOther', 'MembershipTypeCd', 'JoinDt', 'Designation', 'ResignDt'], 'safe'],
            [['FeeAmt'], 'number'],
        ];
    }

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
        $query = TblBadanProfesional::find();

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
            'profId' => $this->profId,
            'JoinDt' => $this->JoinDt,
            'FeeAmt' => $this->FeeAmt,
            'ResignDt' => $this->ResignDt,
            'ProfAssocStatus' => $this->ProfAssocStatus,
        ]);

        $query->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'ProfBodyCd', $this->ProfBodyCd])
            ->andFilterWhere(['like', 'ProfBodyOther', $this->ProfBodyOther])
            ->andFilterWhere(['like', 'MembershipTypeCd', $this->MembershipTypeCd])
            ->andFilterWhere(['like', 'Designation', $this->Designation]);

        return $dataProvider;
    }
    public function searchFPSKApproval($params)
    {
        $query = TblBadanProfesional::find()->where(['isVerified'=>0])->andWhere(['isMedicalBody'=>1]);

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
            'profId' => $this->profId,
            'JoinDt' => $this->JoinDt,
            'FeeAmt' => $this->FeeAmt,
            'ResignDt' => $this->ResignDt,
            'ProfAssocStatus' => $this->ProfAssocStatus,
        ]);

        $query->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'ProfBodyCd', $this->ProfBodyCd])
            ->andFilterWhere(['like', 'ProfBodyOther', $this->ProfBodyOther])
            ->andFilterWhere(['like', 'MembershipTypeCd', $this->MembershipTypeCd])
            ->andFilterWhere(['like', 'Designation', $this->Designation]);

        return $dataProvider;
    }
}
