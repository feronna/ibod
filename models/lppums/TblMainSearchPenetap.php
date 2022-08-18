<?php

namespace app\models\lppums;

use Yii;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\lppums\TblMain;

/**
 * TblMainSearch represents the model behind the search form of `app\models\lnpt\TblMain`.
 */
class TblMainSearchPenetap extends TblMain
{

    public $jenis_carian;
    public $CONm;
    public $ICNO;
    public $DeptId;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['DeptId', 'jenis_carian', 'lpp_id', 'PYD_sts_lantikan', 'gred_jawatan_id', 'jspiu', 'gred_jawatan_id_PPP', 'jspiu_PPP', 'gred_jawatan_id_PPK', 'jspiu_PPK', 'PYD_sah', 'PPP_sah', 'PPK_sah'], 'integer'],
            [['ICNO', 'CONm', 'lpp_datetime', 'PYD', 'tahun', 'PPP', 'PPK', 'PP_ALL', 'PYD_sah_datetime', 'PPP_sah_datetime', 'PPK_sah_datetime', 'KJ_sah', 'KJ_sah_datetime'], 'safe'],
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
        $query = TblMain::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->jenis_carian == '1') {
            $query = $query->andFilterWhere(['like', 'PYD', Yii::$app->user->getId()])->orderBy(['lpp_datetime' => SORT_DESC]);
        } elseif ($this->jenis_carian == '2') {
            $query = $query->joinWith('pyd', false, 'LEFT JOIN')->andFilterWhere(['hronline.tblprcobiodata.DeptId' => $this->DeptId])->orderBy(['lpp_datetime' => SORT_DESC]);
        } elseif ($this->jenis_carian == '3') {
            $query = $query->joinWith('pyd', false, 'LEFT JOIN')->andFilterWhere(['like', 'hronline.tblprcobiodata.CONm', $this->CONm])->andFilterWhere(['like', 'hronline.tblprcobiodata.ICNO', $this->ICNO]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'lpp_id' => $this->lpp_id,
            'lpp_datetime' => $this->lpp_datetime,
            'PYD_sts_lantikan' => $this->PYD_sts_lantikan,
            'gred_jawatan_id' => $this->gred_jawatan_id,
            'tahun' => $this->tahun,
            //            'jspiu' => $this->jspiu,
            'gred_jawatan_id_PPP' => $this->gred_jawatan_id_PPP,
            'jspiu_PPP' => $this->jspiu_PPP,
            'gred_jawatan_id_PPK' => $this->gred_jawatan_id_PPK,
            'jspiu_PPK' => $this->jspiu_PPK,
            'PYD_sah' => $this->PYD_sah,
            'PYD_sah_datetime' => $this->PYD_sah_datetime,
            'PPP_sah' => $this->PPP_sah,
            'PPP_sah_datetime' => $this->PPP_sah_datetime,
            'PPK_sah' => $this->PPK_sah,
            'PPK_sah_datetime' => $this->PPK_sah_datetime,
            'KJ_sah_datetime' => $this->KJ_sah_datetime,
        ]);

        //        $query->andFilterWhere(['like', 'PYD', $this->PYD])
        //            ->andFilterWhere(['like', 'PPP', $this->PPP])
        //            ->andFilterWhere(['like', 'PPK', $this->PPK])
        //            ->andFilterWhere(['like', 'PP_ALL', $this->PP_ALL])
        //            ->andFilterWhere(['like', 'KJ_sah', $this->KJ_sah]);

        return $dataProvider;
    }

    public function formName()
    {
        return '';
    }
}
