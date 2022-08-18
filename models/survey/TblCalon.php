<?php

namespace app\models\survey;

use app\models\hronline\Adminposition;
use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Tblrscoadminpost;
use yii\helpers\Html;

/**
 * This is the model class for table "hrm.survey_tbl_calon".
 *
 * @property int $id
 * @property int $aktiviti_id survey_tbl_aktiviti ID
 * @property string $icno Tblprcobiodata
 * @property string $syor_icno Syor ICNO / Dekan / KJ
 * @property string $total_vote Total Vote
 * @property string $syor Syor
 * @property string $syor_dt Syor DT
 * @property string $create_dt calon Create DT
 */
class TblCalon extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.survey_tbl_calon';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['aktiviti_id', 'total_vote'], 'integer'],
            [['syor', 'remark_vc'], 'string'],
            [['syor_dt', 'create_dt', 'total_vote','vc_dt'], 'safe'],
            [['syor_icno'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'aktiviti_id' => 'survey_tbl_aktiviti ID',
            'icno' => 'Tblprcobiodata',
            'syor_icno' => 'Syor ICNO / Dekan / KJ',
            'syor' => 'Syor',
            'syor_dt' => 'Syor DT',
            'total_vote' => 'Total Vote',
            'create_dt' => 'calon Create DT',
        ];
    }

    public function getKakitangan()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }

    public function getPengesyor()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'syor_icno']);
    }

    public static function syorKetua($key)
    {
        $model = self::find()->where(['SHA2(id,"256")' => $key])->one();

        if ($model->syor) {
            return $model->syor;
        } else {
            return Html::a('<i class="fa fa-pencil-square-o"></i>', ['syor', 'id' => $model->id]);
        }
    }

    public function getFormatSyorDt()
    {
        return date('d/m/Y H:i A', strtotime(str_replace("-", "/", $this->syor_dt)));
    }

    public function getTotalVote()
    {
        return TblVotes::totalVoteCalon($this->id);
    }

    public static function filterSenaraiNama($dept_id, $array_calon =null, $name=null, $phd=null, $gred=null, $tempoh=null, $program=null, $tetap=null)
    {

            $gred_no = $gred ? 51 : null;
            $bersara = $tempoh ? 3 : null;
        
            $kakitangan = Tblprcobiodata::find()
                ->joinWith('jawatan')
                ->where(['DeptId' => $dept_id, 'Status' => 1, 'job_category' => 1])
                ->andFilterWhere(['not', ['icno'=>$array_calon]])
                ->andFilterWhere(['LIKE', 'tblprcobiodata.CONm', $name])
                ->andFilterWhere(['HighestEduLevelCd'=> $phd])
                ->andFilterWhere(['KodProgram'=> $program])
                ->andFilterWhere(['statLantikan'=> $tetap])
                ->andFilterWhere(['>=','gred_no', $gred_no])
                ->andFilterWhere(['<=','YEAR(NOW()) -YEAR(startDateLantik)', $bersara])
                ->all();

        return $kakitangan;
    }

    public static function jwtnPentadbiran($icno){

        $date = date('Y-m-d');

        $model = Tblrscoadminpost::find()->where(['ICNO'=>$icno, 'flag'=>1])->one();

        if($model){
            return $model->adminpos->position_name;
        }

        return '-';

    }

    public function getJwtnPentadbiran()
    {
        return $this->jwtnPentadbiran($this->icno);
    }
}
