<?php

namespace app\models\esticker;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\esticker\TblStickerKontraktor;

/**
 * RekodKenderaanKontraktorSearch represents the model behind the search form of `app\models\esticker\TblStickerKontraktor`.
 */
class RekodKenderaanKontraktorSearch extends TblStickerKontraktor
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['id_kontraktor', 'v_co_icno', 'veh_owner', 'veh_user', 'rel_owner_user', 'reg_number', 'veh_color', 'veh_type', 'veh_brand', 'veh_model', 'roadtax_no', 'roadtax_exp', 'lesen_exp', 'lesen_no', 'daftar_date', 'updater', 'status_kenderaan', 'catatan', 'filename_grant'], 'safe'],
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
        $query = TblStickerKontraktor::find();

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
            'id' => $this->id,
            'roadtax_exp' => $this->roadtax_exp,
            'daftar_date' => $this->daftar_date,
        ]);

        $query->andFilterWhere(['=', 'id_kontraktor', $this->id_kontraktor])
            ->andFilterWhere(['like', 'v_co_icno', $this->v_co_icno])
            ->andFilterWhere(['like', 'veh_owner', $this->veh_owner])
            ->andFilterWhere(['like', 'veh_user', '%'.$this->veh_user.'%',false])
            ->andFilterWhere(['like', 'rel_owner_user', $this->rel_owner_user])
            ->andFilterWhere(['like', 'reg_number', $this->reg_number])
            ->andFilterWhere(['like', 'veh_color', $this->veh_color])
            ->andFilterWhere(['like', 'veh_type', $this->veh_type])
            ->andFilterWhere(['like', 'veh_brand', $this->veh_brand])
            ->andFilterWhere(['like', 'veh_model', $this->veh_model])
            ->andFilterWhere(['like', 'roadtax_no', $this->roadtax_no])
            ->andFilterWhere(['like', 'lesen_exp', $this->lesen_exp])
            ->andFilterWhere(['like', 'lesen_no', $this->lesen_no])
            ->andFilterWhere(['like', 'updater', $this->updater])
            ->andFilterWhere(['like', 'status_kenderaan', $this->status_kenderaan])
            ->andFilterWhere(['like', 'catatan', $this->catatan])
            ->andFilterWhere(['like', 'filename_grant', $this->filename_grant]);

        return $dataProvider;
    }
}
