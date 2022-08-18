<?php

namespace app\models\hronline_gaji;

use app\models\gaji\TblKumpStaf;
use app\models\gaji\TblKumpulan;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline_gaji\Tblstaffrocbatch;

class TblstaffrocbatchSearch extends Tblstaffrocbatch
{  
    public $carian_data;
    
    public function rules()
    {
        return [
            [['carian_data','srb_cmpy_code', 'srb_batch_code', 'srb_staff_id', 'srb_change_reason','srb_enter_date', 'srb_verify_date', 'srb_approve_date', 'srb_cancel_date'], 'safe'],
            [['srb_cmpy_code', 'srb_status', 'srb_process_dept', 'srb_effective_date', 'srb_dept_code', 'srb_job_code'], 'string', 'max' => 10],
            [['srb_batch_code'], 'string', 'max' => 50],
            [['srb_staff_id', 'srb_change_reason', 'srb_enter_by', 'srb_verify_by', 'srb_approve_by', 'srb_cancel_by', 'SRB_SOURCE'], 'string', 'max' => 30],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    public function searchKemasukan($params)
    {
        $lpg_allowed = $this->LpgAllowed(Yii::$app->user->getId());
        $query = Tblstaffrocbatch::find()->where(['LIKE','srb_status','Entry'])->andWhere(['IN','srb_change_reason', $lpg_allowed])->orderBy(['srb_enter_date'=>SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere(['or',['like', 'srb_batch_code', $this->carian_data],['like', 'srb_staff_id', $this->carian_data]]);

        return $dataProvider;
    }

    public function searchSemakan($params)
    {   
        $lpg_allowed = $this->LpgAllowed(Yii::$app->user->getId());
        $query = Tblstaffrocbatch::find()->where(['LIKE','srb_status','APPLY'])->andWhere(['IN','srb_change_reason', $lpg_allowed])->orderBy(['srb_enter_date'=>SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        // if(empty($this->carian_data)){
        //     // $query->where('0=1');
        //     // return $dataProvider;
        // }

        $query->andFilterWhere(['or',['like', 'srb_batch_code', $this->carian_data],['like', 'srb_staff_id', $this->carian_data]]);

        return $dataProvider;
    }
    public function searchSemakanDiterima($params)
    {
        $query = Tblstaffrocbatch::find()->where(['LIKE','srb_status','VERIFY']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere(['or',['like', 'srb_batch_code', $this->carian_data],['like', 'srb_staff_id', $this->carian_data]]);

        return $dataProvider;
    }
    public function searchSemakanDipulangkan($params)
    {
        $query = Tblstaffrocbatch::find()->where(['LIKE','srb_status','semakan_dipulangkan']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere(['or',['like', 'srb_batch_code', $this->carian_data],['like', 'srb_staff_id', $this->carian_data]]);

        return $dataProvider;
    }
    

    public function searchKelulusan($params)
    {
        $lpg_allowed = $this->LpgAllowed(Yii::$app->user->getId());
        $query = Tblstaffrocbatch::find()->where(['LIKE','srb_status','VERIFY'])->andWhere(['IN','srb_change_reason', $lpg_allowed])->orderBy(['srb_enter_date'=>SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        // if(empty($this->carian_data)){
        //     // $query->where('0=1');
        //     // return $dataProvider;
        // }

        $query->andFilterWhere(['or',['like', 'srb_batch_code', $this->carian_data],['like', 'srb_staff_id', $this->carian_data]]);

        return $dataProvider;
    }

    public function searchDipulang($params)
    {
        $query = Tblstaffrocbatch::find()->where(['LIKE','srb_status','REJECT']);
        

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        // var_dump($this->carian_data);
        // die;
        if(empty($this->carian_data)){
            // $query->where('0=1');
            // return $dataProvider;
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions

        $query->andFilterWhere(['or',['like', 'srb_batch_code', $this->carian_data],['like', 'srb_staff_id', $this->carian_data]]);

      
       

        return $dataProvider;
    }

    private static function LpgAllowed($icno){
        $roles = TblKumpStaf::RoleList($icno);
        $all_lpg_allowed = [];
        for($i = 0 ; $i < count($roles); $i++){
            $lpg_allowed = TblKumpulan::lpgListByRole($icno,$roles[$i], true);
            $all_lpg_allowed = $all_lpg_allowed + $lpg_allowed;
        }
        return $all_lpg_allowed;
    }

    
}
