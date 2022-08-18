<?php

namespace app\models\patrol;

use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "keselamatan.patrol_report_do".
 *
 * @property int $id
 * @property string $icno_do
 * @property string $date
 * @property int $shift_id
 * @property int $pos_id
 * @property string $remark_do
 * @property string $remark_dt
 * @property string $icno_pm
 * @property string $remark_pm
 * @property string $pm_dt
 * @property string $icno_kbk
 * @property string $kbk_remark
 * @property string $kbk_dt
 * @property string $status
 */
class PatrolReportDo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.patrol_report_do';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'remark_dt', 'pm_dt', 'kbk_dt','report_dt'], 'safe'],
            [['shift_id', 'pos_id','campus_id'], 'integer'],
            [['remark_do', 'remark_pm', 'kbk_remark'], 'string'],
            [['icno_do', 'icno_pm', 'icno_kbk', 'status'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno_do' => 'Icno Do',
            'date' => 'Date',
            'shift_id' => 'Shift ID',
            'pos_id' => 'Pos ID',
            'remark_do' => 'Remark Do',
            'remark_dt' => 'Remark Dt',
            'icno_pm' => 'Icno Pm',
            'remark_pm' => 'Remark Pm',
            'pm_dt' => 'Pm Dt',
            'icno_kbk' => 'Icno Kbk',
            'kbk_remark' => 'Kbk Remark',
            'kbk_dt' => 'Kbk Dt',
            'status' => 'Status',
        ];
    }
    public function getKakitangan(){
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno_do']);
    }
    public static function namado($syif,$date,$campus){
        $val = "";
        $model = self::find()->where(['date'=> $date])->andWhere(['shift_id' => $syif])->andWhere(['campus_id'=>$campus])->andWhere(['!=','status','NULL'])->one();
        if($model){
            $val = $model->kakitangan->CONm .' '. $model->report_dt; 
        }
        // var_dump($syif,$date,$campus);
        // var_dump($val);die;

        return $val;
    }
}
