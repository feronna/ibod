<?php

namespace app\models\gaji;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\gaji\RefElaunName;

/**
 * This is the model class for table "hrm.gaji_tblrscoelaun".
 *
 * @property string $el_id PK, auto incr
 * @property string $el_lpg_id
 * @property int $el_elaun_cd
 * @property string $el_amount
 * @property string $el_created_by
 * @property int $el_bln_khidmat Untuk ganjaran kontrak
 */
class Tblrscoelaun extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.gaji_tblrscoelaun';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['el_lpg_id', 'el_elaun_cd', 'el_bln_khidmat'], 'integer'],
            [['el_amount'], 'number'],
            [['el_created_by'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'el_id' => 'El ID',
            'el_lpg_id' => 'El Lpg ID',
            'el_elaun_cd' => 'El Elaun Cd',
            'el_amount' => 'El Amount',
            'el_created_by' => 'El Created By',
            'el_bln_khidmat' => 'El Bln Khidmat',
        ];
    }
    
    public function search($params) {
        
        $query = Tblrscoelaun::find()->orderBy(['el_elaun_cd' => 'ASC']);
        
        //$query->with('department');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                //'pageSize' => 20,
                'pageSize' => 5,
                ],
            'sort' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

//      grid filtering conditions
        $query->andFilterWhere([
            'el_lpg_id' => $this->el_lpg_id,
        ]);

//        $query->andFilterWhere(['like', 'ICNO', $this->ICNO])
//                ->andFilterWhere(['like', 'ReligionCd', $this->ReligionCd])
//                ->andFilterWhere(['like', 'RaceCd', $this->RaceCd])
//                ->andFilterWhere(['like', 'EthnicCd', $this->EthnicCd])
//                ->andFilterWhere(['like', 'ArmyPoliceCd', $this->ArmyPoliceCd])
//                ->andFilterWhere(['like', 'BloodTypeCd', $this->BloodTypeCd])
//                ->andFilterWhere(['like', 'MrtlStatusCd', $this->MrtlStatusCd])
//                ->andFilterWhere(['like', 'TitleCd', $this->TitleCd])
//                ->andFilterWhere(['like', 'GenderCd', $this->GenderCd])
//                ->andFilterWhere(['like', 'COBirthPlaceCd', $this->COBirthPlaceCd])
//                ->andFilterWhere(['like', 'COBirthCountryCd', $this->COBirthCountryCd])
//                ->andFilterWhere(['like', 'NegaraAsalCd', $this->NegaraAsalCd])
//                ->andFilterWhere(['like', 'NegeriAsalCd', $this->NegeriAsalCd])
//                ->andFilterWhere(['like', 'NatCd', $this->NatCd])
//                ->andFilterWhere(['like', 'NatStatusCd', $this->NatStatusCd])
//                ->andFilterWhere(['like', 'CONm', $this->CONm])
//                ->andFilterWhere(['like', 'COEmail', $this->COEmail])
//                ->andFilterWhere(['like', 'COEmail2', $this->COEmail2])
//                ->andFilterWhere(['like', 'COOldID', $this->COOldID])
//                ->andFilterWhere(['like', 'COBirthCertNo', $this->COBirthCertNo])
//                ->andFilterWhere(['like', 'COHPhoneNo', $this->COHPhoneNo])
//                ->andFilterWhere(['like', 'COOffTelNo', $this->COOffTelNo])
//                ->andFilterWhere(['like', 'COOffTelNoExtn', $this->COOffTelNoExtn])
//                ->andFilterWhere(['like', 'COOffTelNoExtn2', $this->COOffTelNoExtn2])
//                ->andFilterWhere(['like', 'COOPass', $this->COOPass])
//                ->andFilterWhere(['like', 'COHPhoneStatus', $this->COHPhoneStatus])
//                ->andFilterWhere(['like', 'gredJawatan_2', $this->gredJawatan_2])
//                ->andFilterWhere(['like', 'jawatanTadbir', $this->jawatanTadbir])
//                ->andFilterWhere(['like', 'last_updater', $this->last_updater])
//                ->andFilterWhere(['like', 'pp', $this->pp])
//                ->andFilterWhere(['like', 'bos', $this->bos])
//                ->andFilterWhere(['like', 'program_ums', $this->program_ums])
//                ->andFilterWhere(['=', 'DeptId', $this->DeptId]);

        return $dataProvider;
    }
    
    public function getElaunName() {
        return $this->hasOne(RefElaunName::className(), ['id' => 'el_elaun_cd']);
    }
}
