<?php

namespace app\models\cuti;

use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "hrm.cuti_tbl_bod".
 *
 * @property int $id
 * @property int $record_id
 * @property string $date_bod
 * @property string $remark
 * @property string $semakan_id
 * @property string $pelulus_id
 * @property string $bsm_id
 * @property int $status 0 - penyelia menyemak 1 - pelulus memperaku back on duty  2 - bsm telah ambil tindakan
 */
class CutiTblBod extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cuti_tbl_bod';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['record_id', 'status'], 'integer'],
            [['date_bod', 'date_semakan', 'lulus_date', 'bsm_date'], 'safe'],
            [['remark'], 'string'],
            [['semakan_id', 'pelulus_id', 'bsm_id'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'record_id' => 'Record ID',
            'date_bod' => 'Date Bod',
            'remark' => 'Remark',
            'semakan_id' => 'Semakan ID',
            'pelulus_id' => 'Pelulus ID',
            'bsm_id' => 'Bsm ID',
            'status' => 'Status',
        ];
    }
    public function getKakitangan()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    public static function status($id)
    {
        $model = self::findOne(['record_id' => $id]);
        $val = '';
        if ($model) {
            if ($model->status == 1) {
                $val = 'Perakuan Ketua Jabatan';
            } else
            if ($model->status == 2) {
                $val = 'Telah Diterima Oleh Ketua Jabatan';
            } else {
                $val = 'Selesai';
            }
        }

        return $val;
    }
    public static function button($id)
    {
        $model = self::findOne(['record_id' => $id]);
        $val = false;
        if ($model) {

            if ($model->status == 2) {
                $val = true;
            }
        }

        return $val;
    }
    public static function buttons($id)
    {
        $model = TblRecords::find()->where(['id' => $id])->andWhere(['!=','file1','NULL'])->andWhere(['!=','file2','NULL'])->one();
        // var_dump($model);die;
        $val = false;
        if ($model) {

                $val = true;  
        }

        return $val;
    }
    public static function totalPendingBod($icno)
    {
        // $count = Yii::$app->cache->get('total-pending-approval-'.$icno);
        // if($stat == 2){
        $count = self::find()
            ->where(['icno' => $icno, 'status' => '1'])
            // ->andWhere(['YEAR(start_date)' => date('Y')])
            ->asArray()
            ->count('id');
        // Yii::$app->cache->set('total-pending-approval-'.$icno, $count);
        // }

        return $count;
    }
    public static function totalPendingBodBsm($icno)
    {
        // $count = Yii::$app->cache->get('total-pending-approval-'.$icno);
        // if($stat == 2){
        $count = self::find()
            ->where(['icno' => $icno, 'status' => '2'])
            // ->andWhere(['YEAR(start_date)' => date('Y')])
            ->asArray()
            ->count('id');
        // Yii::$app->cache->set('total-pending-approval-'.$icno, $count);
        // }

        return $count;
    }
}
