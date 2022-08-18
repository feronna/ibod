<?php

namespace app\models\utilities\epos;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\utilities\epos\PosTblPermohonan;
use yii\helpers\VarDumper;

class PosTblPermohonanSearch extends PosTblPermohonan
{
    public function rules()
    {
        return [
            [['id', 'status_jafpib', 'status_pom', 'jenis_khidmat_mel'], 'integer'],
            [['icno_pemohon', 'tujuan_mel', 'tarikh_mohon', 'alamat_penghantar', 'alamat_penerima', 'icno_pelulus', 'tarikh_status_jafpib', 'icno_pom', 'tarikh_status_pom', 'tracking_no', 'tarikh_dihantar'], 'safe'],
            [['bayaran_mel'], 'number'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = PosTblPermohonan::find();

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
            'tarikh_mohon' => $this->tarikh_mohon,
            'status_jafpib' => $this->status_jafpib,
            'tarikh_status_jafpib' => $this->tarikh_status_jafpib,
            'status_pom' => $this->status_pom,
            'tarikh_status_pom' => $this->tarikh_status_pom,
            'tarikh_dihantar' => $this->tarikh_dihantar,
            'jenis_khidmat_mel' => $this->jenis_khidmat_mel,
            'bayaran_mel' => $this->bayaran_mel,
        ]);

        $query->andFilterWhere(['like', 'icno_pemohon', $this->icno_pemohon])
            ->andFilterWhere(['like', 'tujuan_mel', $this->tujuan_mel])
            ->andFilterWhere(['like', 'alamat_penghantar', $this->alamat_penghantar])
            ->andFilterWhere(['like', 'alamat_penerima', $this->alamat_penerima])
            ->andFilterWhere(['like', 'icno_pelulus', $this->icno_pelulus])
            ->andFilterWhere(['like', 'icno_pom', $this->icno_pom])
            ->andFilterWhere(['like', 'tracking_no', $this->tracking_no]);

        return $dataProvider;
    }
    public function searchJAFPIB($params)
    {
        $DeptId = Yii::$app->user->identity->DeptId;
        $query = PosTblPermohonan::find()->where(['DeptId'=>$DeptId]);

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
            'tarikh_mohon' => $this->tarikh_mohon,
            'status_jafpib' => $this->status_jafpib,
            'tarikh_status_jafpib' => $this->tarikh_status_jafpib,
            'status_pom' => $this->status_pom,
            'tarikh_status_pom' => $this->tarikh_status_pom,
            'tarikh_dihantar' => $this->tarikh_dihantar,
            'jenis_khidmat_mel' => $this->jenis_khidmat_mel,
            'bayaran_mel' => $this->bayaran_mel,
        ]);

        $query->andFilterWhere(['like', 'icno_pemohon', $this->icno_pemohon])
            ->andFilterWhere(['like', 'tujuan_mel', $this->tujuan_mel])
            ->andFilterWhere(['like', 'alamat_penghantar', $this->alamat_penghantar])
            ->andFilterWhere(['like', 'alamat_penerima', $this->alamat_penerima])
            ->andFilterWhere(['like', 'icno_pelulus', $this->icno_pelulus])
            ->andFilterWhere(['like', 'icno_pom', $this->icno_pom])
            ->andFilterWhere(['like', 'tracking_no', $this->tracking_no]);

        return $dataProvider;
    }
    public function searchPejabatMel($params)
    {
        $DeptId = Yii::$app->user->identity->DeptId;
        $query = PosTblPermohonan::find()->where(['status_jafpib'=>'2']);

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
            'tarikh_mohon' => $this->tarikh_mohon,
            'status_jafpib' => $this->status_jafpib,
            'tarikh_status_jafpib' => $this->tarikh_status_jafpib,
            'status_pom' => $this->status_pom,
            'tarikh_status_pom' => $this->tarikh_status_pom,
            'tarikh_dihantar' => $this->tarikh_dihantar,
            'jenis_khidmat_mel' => $this->jenis_khidmat_mel,
            'bayaran_mel' => $this->bayaran_mel,
        ]);

        $query->andFilterWhere(['like', 'icno_pemohon', $this->icno_pemohon])
            ->andFilterWhere(['like', 'tujuan_mel', $this->tujuan_mel])
            ->andFilterWhere(['like', 'alamat_penghantar', $this->alamat_penghantar])
            ->andFilterWhere(['like', 'alamat_penerima', $this->alamat_penerima])
            ->andFilterWhere(['like', 'icno_pelulus', $this->icno_pelulus])
            ->andFilterWhere(['like', 'icno_pom', $this->icno_pom])
            ->andFilterWhere(['like', 'tracking_no', $this->tracking_no]);

        return $dataProvider;
    }
}
