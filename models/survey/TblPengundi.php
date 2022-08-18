<?php

namespace app\models\survey;

use Yii;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "hrm.survey_tbl_pengundi".
 *
 * @property int $id
 * @property int $aktiviti_id survey_tbl_aktiviti ID
 * @property string $icno Tblprcobiodata
 * @property string $create_dt pengundi Create DT
 */
class TblPengundi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.survey_tbl_pengundi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['aktiviti_id', 'vote_status'], 'integer'],
            [['create_dt', 'vote_status', 'vote_dt'], 'safe'],
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
            'create_dt' => 'pengundi Create DT',
            'vote_status' => 'Status',
            'vote_dt' => 'Date/Time',
            'statusText' => 'Status',
        ];
    }

    public function getKakitangan()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }

    public function getStatusText()
    {
        if ($this->vote_status == 1) {
            return 'Completed';
        } else {
            return 'Pending';
        }
    }

    public static function statusVote($aktiviti_id, $icno)
    {
        $model = self::findOne(['aktiviti_id' => $aktiviti_id, 'icno' => $icno]);

        if ($model) {
            return $model->getStatusText();
        }

        return false;
    }

    public static function filterSenaraiNama($dept_id, $array_calon = null, $name = null, $phd = null, $gred = null, $tempoh = null, $program = null, $tetap = null)
    {

        $gred_no = $gred ? 51 : null;
        $bersara = $tempoh ? 3 : null;

        $kakitangan = Tblprcobiodata::find()
            ->joinWith('jawatan')
            ->where(['DeptId' => $dept_id, 'job_category' => 1])
            ->andWhere(['<>', 'status', 6])
            ->andFilterWhere(['not', ['icno' => $array_calon]])
            ->andFilterWhere(['LIKE', 'tblprcobiodata.CONm', $name])
            ->andFilterWhere(['HighestEduLevelCd' => $phd])
            ->andFilterWhere(['KodProgram' => $program])
            ->andFilterWhere(['statLantikan' => $tetap])
            ->andFilterWhere(['>=', 'gred_no', $gred_no])
            ->andFilterWhere(['<=', 'YEAR(NOW()) -YEAR(startDateLantik)', $bersara])
            ->all();

        return $kakitangan;
    }
}
