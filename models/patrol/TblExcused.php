<?php

namespace app\models\patrol;

use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "keselamatan.patrol_tbl_excused".
 *
 * @property int $id
 * @property string $icno
 * @property int $pos_id
 * @property string $datetime
 * @property string $do_onduty
 * @property string $status
 * @property string $approve_dt
 * @property string $remark_dt
 */
class TblExcused extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.patrol_tbl_excused';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pos_id','campus_id','shift_id','type'], 'integer'],
            [['remark'],'required','message' => 'Tolong Isi Ruangan Ini'],
            [['approve_dt','date','remark_dt'], 'safe'],
            [['icno', 'do_onduty'], 'string', 'max' => 12],
            [['status'], 'string', 'max' => 8],
            [['remark','approver_remark'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'pos_id' => 'Pos ID',
            // 'datetime' => 'Datetime',
            'do_onduty' => 'Do Onduty',
            'status' => 'Status',
            'approve_dt' => 'Approve Dt',
            'remark_dt' => 'Remark Dt',
        ];
    }
    public static function remark($icno,$date,$pos,$shift){
        $val = "";
        $model = self::find()->where(['icno' => $icno])->andWhere(['date' => $date])->andWhere(['pos_id' => $pos])->andWhere(['shift_id' => $shift])->one();
        if($model){
            $val = $model->remark. ' ' .'<span class="label label-primary">' . $model->status . '</span>';
        }
        return $val;
    }
    public static function remarkdo($icno,$date,$pos,$shift){
        $val = "";
        $model = self::find()->where(['icno' => $icno])->andWhere(['date' => $date])->andWhere(['pos_id' => $pos])->andWhere(['shift_id' => $shift])->andWhere(['!=','approver_remark','NULL'])->one();
        if($model){
            $val = $model->approver_remark. ' ' .'<span class="label label-primary">' . $model->status . '</span>';
        }
        return $val;
    }
    public function getKakitangan()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
}
