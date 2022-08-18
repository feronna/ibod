<?php

namespace app\models\elnpt;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\elnpt\TblMain;
use app\models\elnpt\Department;

/**
 * TblMainSearch represents the model behind the search form of `app\models\elnpt\TblMain`.
 */
class TblMainSearch extends TblMain
{
    public $kategori;
    public $CONm;
    public $sah_markah;
    public $cadang_apc;
    public $panel_apc;
    public $apt;
    public $terima_apc;
    public $naik_pgkt;
    public $khidmat;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['CONm', 'string'],
            [[
                'lpp_datetime', 'PYD', 'tahun', 'PPP', 'PPK', 'PEER', 'cadang_apc', 'panel_apc', 'apt', 'terima_apc', 'naik_pgkt', 'khidmat'
            ], 'safe'],
            [[
                'lpp_id', 'PYD_sts_lantikan', 'gred_jawatan_id_PPP', 'jspiu_PPP', 'gred_jawatan_id_PPK', 'jspiu_PPK',
                'gred_jawatan_id_PEER', 'jspiu_PEER',
                'PYD_sah', 'PPP_sah', 'PPK_sah', 'PEER_sah', 'is_aktif', 'markah_sah', 'sah_markah', 'kategori'
            ], 'integer'],
            [[
                'PYD_sah_datetime', 'PPP_sah_datetime', 'PPK_sah_datetime', 'PEER_sah_datetime',
                'catatan', 'deleted_by', 'markah_sah_datetime', 'gred_jawatan_id', 'gred_jawatan_id', 'jfpiu'
            ], 'safe'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $dept = null, $tahun = null)
    {
        $query = TblMain::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => ['attributes' => ['`g`.`CONm`', '`m`.`markah`']],
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->innerJoinWith('guru g', true)
            ->joinWith('markahAll m', true, 'LEFT JOIN')
            ->joinWith('cdg cadang', true, 'LEFT JOIN')
            ->joinWith('apc apc', true, 'LEFT JOIN')
            ->joinWith('apt apt', true, 'LEFT JOIN')
            ->andFilterWhere(['jfpiu' => $dept ?? $this->jfpiu])
            ->andFilterWhere(['like', 'g.CONm', $this->CONm])
            ->andFilterWhere(['like', 'PYD', $this->PYD])
            ->andFilterWhere(['tahun' => $tahun ?? $this->tahun])
            ->andFilterWhere(['PYD_sah' => $this->PYD_sah])
            ->andFilterWhere(['PPP_sah' => $this->PPP_sah])
            ->andFilterWhere(['PPK_sah' => $this->PPK_sah])
            ->andFilterWhere(['PEER_sah' => $this->PEER_sah])
            ->andFilterWhere(['gred_jawatan_id' => $this->gred_jawatan_id])
            ->andFilterWhere(['PPP' => $this->PPP])
            ->andFilterWhere(['PPK' => $this->PPK])
            ->andFilterWhere(['PEER' => $this->PEER]);
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
        }
        if ($this->khidmat) {
            $query->joinWith('sandanganKhidmat sdgKhidmat', true, 'LEFT JOIN');
            $query->andFilterWhere(['<=', 'sdgKhidmat.start_date', '2019-01-01']);
        }
        if ($this->naik_pgkt) {
            $query->joinWith('sandangan sdg1', true, 'LEFT JOIN');
            $query->andFilterWhere(['or', ['<=', new \yii\db\Expression('YEAR(`sdg1`.`latest_start_date`)'), (($tahun ?? $this->tahun) - 2)], ['IS', '`sdg1`.`latest_start_date`', new \yii\db\Expression('NULL')]]);
        }
        if ($this->terima_apc) {
            $query->andFilterWhere(['or', ['<=', new \yii\db\Expression('YEAR(`apc`.`last_date_awd`)'), (($tahun ?? $this->tahun) - 2)], ['IS', '`apc`.`last_date_awd`', new \yii\db\Expression('NULL')]]);
        }
        if ($this->cadang_apc) {
            $query->andFilterWhere(['cadang.cadang' => 1]);
        }
        if ($this->panel_apc) {
            $query->andFilterWhere(['cadang.panel' => 1]);
        }
        if ($this->apt) {
            $query->andFilterWhere(['IS NOT', 'apt.ICNO', new \yii\db\Expression('NULL')]);
        }
        if ($this->kategori) {
            $arry = [
                '-1' => 'TIADA MAKLUMAT / BELUM ISI',
                '1' => 'LEMAH',
                '50' => 'KURANG MEMUASKAN',
                '60' => 'SEDERHANA',
                '80' => 'BAIK',
                '90' => 'CEMERLANG',
            ];

            $keys = array_keys($arry);
            $index = array_search($this->kategori, $keys);
            if ($this->kategori < 0) {
                $query->andFilterWhere(['=', 'm.markah', '0']);
            } else if (count($arry) <= $index + 1) {
                $query->andFilterWhere(['>=', 'm.markah', (int)$this->kategori]);
            } else {
                $query->andFilterWhere(['between', 'm.markah', (int)$this->kategori, $keys[$index + 1] - 1]);
            }
        }
        return $dataProvider;
    }
    public function getDept()
    {
        $dept = Department::find()->select(['fullname'])->where(['id' => $this->jfpiu])->one();
        return $dept->fullname;
    }
    public function formName()
    {
        return '';
    }
}
