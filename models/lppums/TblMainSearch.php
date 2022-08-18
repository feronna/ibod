<?php

namespace app\models\lppums;

use Yii;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\lppums\TblMain;

/**
 * TblMainSearch represents the model behind the search form of `app\models\lnpt\TblMain`.
 */
class TblMainSearch extends TblMain
{

    public $jenis_carian;
    public $CONm;
    public $ICNO;
    public $DeptId;
    public $sah_markah;

    public $cadang_apc;
    public $panel_apc;
    public $apt;
    public $terima_apc;
    public $naik_pgkt;
    public $khidmat;

    public $gred_skim;
    public $gred_no;
    public $job_group;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['DeptId', 'jenis_carian', 'lpp_id', 'PYD_sts_lantikan', 'gred_jawatan_id_PPP', 'jspiu_PPP', 'gred_jawatan_id_PPK', 'jspiu_PPK', 'PYD_sah', 'PPP_sah', 'PPK_sah', 'markah_sah', 'sah_markah'], 'integer'],
            [[
                'ICNO', 'CONm', 'lpp_datetime', 'PYD', 'tahun', 'PPP', 'PPK', 'PP_ALL', 'PYD_sah_datetime', 'PPP_sah_datetime', 'PPK_sah_datetime', 'KJ_sah', 'KJ_sah_datetime', 'markah_sah_datetime', 'cadang_apc', 'panel_apc', 'apt', 'terima_apc', 'naik_pgkt', 'khidmat', 'gred_jawatan_id', 'jspiu', 'gred_skim', 'gred_no', 'job_group',
            ], 'safe'],
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
                'pageSize' => 50,
            ],
            // 'sort' => [
            //     'attributes' => ['markah_pp']
            //     // 'defaultOrder' => [
            //     //     'markah_pp' => SORT_DESC,
            //     // ],
            // ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (is_null($params) || empty($params)) {
            $query->where('0 = 1');
            return $dataProvider;
        }

        if ($this->jenis_carian == '1') {
            $query = $query->andFilterWhere(['like', 'PYD', Yii::$app->user->getId()])->orderBy(['lpp_datetime' => SORT_DESC]);
        } elseif ($this->jenis_carian == '2') {
            $query = $query->joinWith('pyd', false, 'LEFT JOIN')->orderBy(['lpp_datetime' => SORT_DESC]);
        } elseif ($this->jenis_carian == '3') {
            $query = $query->joinWith('pyd', false, 'LEFT JOIN')->andFilterWhere(['like', 'hronline.tblprcobiodata.CONm', $this->CONm])->andFilterWhere(['like', 'hronline.tblprcobiodata.ICNO', $this->ICNO]);
        } elseif (is_null($this->sah_markah)) {
            $query->joinWith('avgMark m', true, 'LEFT JOIN')
                ->joinWith('pyd p', true, 'LEFT JOIN')
                ->joinWith('cdg cadang', true, 'LEFT JOIN')
                ->joinWith('apc apc', true, 'LEFT JOIN')
                ->joinWith('apt apt', true, 'LEFT JOIN')
                ->joinWith('gredJawatan gj', true, 'LEFT JOIN')
                ->andFilterWhere(['>=', 'm.average_mark', 85]);

            if ($this->khidmat) {
                $query->joinWith('tahunLpp thn', true, 'LEFT JOIN');
                $query->joinWith('sandangan sdg', true, 'LEFT JOIN');
                // $query->innerJoinWith('cdg cadang', true);
                // $query->andFilterWhere(['IS NOT', 'sdg.icno', new \yii\db\Expression('NULL')]);
                $query->andFilterWhere(['>', new \yii\db\Expression('TIMESTAMPDIFF(month, `sdg`.`latest_start_date`, `thn`.`penilaian_PPK_tamat`)'), 12]);
            }

            if ($this->naik_pgkt && $this->tahun) {
                $query->joinWith('sandangan3 sdg', true, 'LEFT JOIN');
                // $query->innerJoinWith('cdg cadang', true);
                // $query->andFilterWhere(['IS NOT', 'sdg.icno', new \yii\db\Expression('NULL')]);
                // $query->andFilterWhere(['>', new \yii\db\Expression('ABS('.$this->tahun.' - YEAR(`sdg`.`latest_start_date`))'), 1]);
                $query->andFilterWhere(['or', ['<=', new \yii\db\Expression('YEAR(`sdg`.`start_date`)'), ($this->tahun - 1)], ['IS', '`sdg`.`start_date`', new \yii\db\Expression('NULL')]]);
            }

            if ($this->terima_apc && $this->tahun) {
                // $query->innerJoinWith('apc apc', true);
                // $query->innerJoinWith('cdg cadang', true);
                // $query->andFilterWhere(['IS NOT', 'apc.ICNO', new \yii\db\Expression('NULL')]);
                // $query->andFilterWhere(['>', new \yii\db\Expression('ABS('.$this->tahun.' - YEAR(`apc`.`last_date_awd`))'), 1]);
                $query->andFilterWhere(['or', ['<=', new \yii\db\Expression('YEAR(`apc`.`last_date_awd`)'), ($this->tahun - 1)], ['IS', '`apc`.`last_date_awd`', new \yii\db\Expression('NULL')]]);
            }

            if ($this->cadang_apc) {
                // $query->innerJoinWith('apc apc', true);
                // $query->innerJoinWith('cdg cadang', true);
                // $query->andFilterWhere(['IS NOT', 'apc.ICNO', new \yii\db\Expression('NULL')]);
                $query->andFilterWhere(['cadang.cadang' => 2]);
            }

            if ($this->panel_apc) {
                // $query->innerJoinWith('apc apc', true);
                // $query->innerJoinWith('cdg cadang', true);
                // $query->andFilterWhere(['IS NOT', 'apc.ICNO', new \yii\db\Expression('NULL')]);
                $query->andFilterWhere(['cadang.cadang' => 3]);
            }

            if ($this->apt) {
                // $query->innerJoinWith('apt apt', true);
                $query->andFilterWhere(['IS NOT', 'apt.ICNO', new \yii\db\Expression('NULL')]);
            }

            // if($this->gred_no && $this->gred_skim) {
            //     $query->andFilterWhere(['gj.gred_skim' => $this->gred_skim, 'gj.gred_no' => $this->gred_no]);
            // }

            $query->andFilterWhere(['LIKE', 'p.CONm', $this->CONm]);

            $query->andFilterWhere(['gj.gred_skim' => $this->gred_skim, 'gj.gred_no' => $this->gred_no, 'gj.job_group' => $this->job_group]);

            $dataProvider->setSort([
                'attributes' => [
                    '`p`.`CONm`',
                    '`m`.`average_mark`',
                    // 'defaultOrder' => [
                    //     '`m`.`average_mark`' => SORT_DESC,
                    // ],
                ]
            ]);

            // $dataProvider->sort->attributes['`m`.`average_mark`'] = [ 
            //     'asc' => ['`m`.`average_mark`' => SORT_ASC],
            //     'desc' => ['`m`.`average_mark`' => SORT_DESC],
            //     'default' => SORT_DESC,
            // ]; 
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'lpp_id' => $this->lpp_id,
            'lpp_datetime' => $this->lpp_datetime,
            'PYD_sts_lantikan' => $this->PYD_sts_lantikan,
            'gred_jawatan_id' => $this->gred_jawatan_id,
            'tahun' => $this->tahun,
            'jspiu' => $this->DeptId ?? $this->jspiu,
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

        $query->andFilterWhere(['like', 'PYD', $this->PYD])
            ->andFilterWhere(['PPP' => $this->PPP])
            ->andFilterWhere(['PPK' => $this->PPK])
            ->andFilterWhere(['PP_ALL' => $this->PP_ALL])
            ->andFilterWhere(['like', 'PP_ALL', $this->PP_ALL])
            ->andFilterWhere(['like', 'KJ_sah', $this->KJ_sah]);

        switch ($this->sah_markah) {
            case 1:
                $query->andFilterWhere(['AND', ['markah_sah' => 1], ['IS NOT', 'markah_sah_datetime', null]]);
                break;
            case 2:
                $query->andFilterWhere(['AND', ['markah_sah' => 0], ['IS NOT', 'markah_sah_datetime', new \yii\db\Expression('NULL')]]);
                break;
            case 3:
                $query->andFilterWhere(['AND', ['markah_sah' => 0], ['markah_sah_datetime' => null]]);
                break;
            default:
                $query;
                break;
        }

        return $dataProvider;
    }

    public function formName()
    {
        return '';
    }
}
