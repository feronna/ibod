<?php

namespace app\models\cuti;

use app\models\hronline\Department;
use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "hrm.cuti_gcr_application".
 *
 * @property int $id
 * @property string $pemohon_icno
 * @property string $mohon_dt
 * @property int $leave_balance
 * @property int $gcr_applied
 * @property int $cbth_applied
 * @property string $semakan_by penyelia cuti jfpib
 * @property string $semakan_dt
 * @property string $peraku_by ketua jabatan jfpib pemohon
 * @property string $peraku_dt
 * @property string $lulus_by ketua bsm
 * @property string $lulus_dt
 * @property string $bsm_semak utk tujuan rekod layak telah dikemaskini
 * @property string $bsm_semak_dt
 * @property string $status
 */
class GcrApplication extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cuti_gcr_application';
    }
    // public $tempv1;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mohon_dt', 'semakan_dt', 'peraku_dt', 'lulus_dt', 'bsm_semak_dt'], 'safe'],
            [['leave_balance', 'gcr_applied', 'cbth_applied', 'dept_id', 'agreement','isActive','flag'], 'integer'],
            [['pemohon_icno', 'semakan_by', 'peraku_by', 'lulus_by', 'bsm_semak'], 'string', 'max' => 12],
            [['status'], 'string', 'max' => 10],
            [['semakan_remark'], 'string', 'max' => 255],
            [['gcr_applied'], 'required', 'message' => 'Sila Masukkan GCR / Please Enter GCR'],
            [['cbth_applied'], 'required', 'message' => 'Sila Masukkan CBTH / Please Enter CBTH'],
            [['agreement'], 'required', 'requiredValue' => 1, 'message' => 'Sila Tandakan Ruangan Ini'],
            [['semakan_by'], 'required'],
            [['cbth_applied'], 'checkCbth', 'on' => ['carry']],
            [['gcr_applied'], 'checkGcr', 'on' => ['carry']],
            // [['tempv1'], 'checkTotal', 'on' => ['carry']],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pemohon_icno' => 'Pemohon Icno',
            'mohon_dt' => 'Mohon Dt',
            'leave_balance' => 'Leave Balance',
            'gcr_applied' => 'GCR',
            'cbth_applied' => 'CBTH',
            'semakan_by' => 'Semakan By',
            'semakan_dt' => 'Semakan Dt',
            'peraku_by' => 'Peraku By',
            'peraku_dt' => 'Peraku Dt',
            'lulus_by' => 'Lulus By',
            'lulus_dt' => 'Lulus Dt',
            'bsm_semak' => 'Bsm Semak',
            'bsm_semak_dt' => 'Bsm Semak Dt',
            'status' => 'Status',
            'semakan_remark' => 'Remark',
            'agreement' => 'Agreement'
        ];
    }
    public static function getGcr($id)
    {

        $layak = Layak::find()->where(['layak_id' => $id])->orderBy(['layak_tamat' => SORT_DESC])->one();

        $check = 0;
        // if ($layak->layak_cuti  < 20) {
        //     $check = $layak->layak_cuti;
        // } else {
            if ($layak->layak_cuti  >= 30) {
                $check = 15;
            } elseif ($layak->layak_cuti == 25) {
                $check = 12;
            } else {
                $check = ($layak->layak_cuti) / 2;
            }
        // }
        // $check = ($this->layak_cuti) / 2;
        // var_dump($check);die;

        return floor($check);
    }

    public static function getStatus($id)
    {
        $data = Tblprcobiodata::find()->where(['ICNO' => $id])->one();

        $check = self::find()->where(['pemohon_icno' => $id])->andWhere(['isActive'=>1])->one();
        if ($check) {
            return 'Telah Memohon';
        } elseif ($data->statLantikan != 1) {
            return 'Lantikan Kontrak';
        } else {
            return 'Belum Memohon';
        }
    }
    public static function getStatuss($id)
    {
        $data = Tblprcobiodata::find()->where(['ICNO' => $id])->one();

        $val = '';
        $check = self::find()->where(['pemohon_icno' => $id])->andWhere(['isActive'=>1])->one();
        if ($check) {
            $val = $check->status;
        }
        return $val;
    }
    public static function getCbth($id)
    {

        $layak = Layak::findOne(['layak_id' => $id]);
        $check = 0;

        if ($layak->layak_cuti  <= 20) {
            $check = 40;
        } else
        if ($layak->layak_cuti  == 20) {
            $check = 40;
        } else
        if ($layak->layak_cuti  == 25) {
            $check = 50;
        } else
        if ($layak->layak_cuti  == 30) {
            $check = 60;
        } else
        if ($layak->layak_cuti  >= 35) {
            $check = 70;
        } else {
            $check = 40;
        }
        // $check = ($this->layak_cuti) / 2;
        // var_dump($lyk->layak_cuti);die;

        return floor($check);
    }

    public function checkGcr($attribute, $params)
    {

        $id = Yii::$app->user->getId();
        $data = date('m');

        // $model = new GcrApplication();
        if ($data == '01') {
        $curr_yr = date('Y', strtotime('-1 year'));
        } else {
            $curr_yr = date('Y');
        }
        $tmt = $curr_yr . '-12-31';

        $layak = Layak::find()->where(['layak_icno' => $id])->andWhere(['layak_tamat' => $tmt])->one();
        $bal = Layak::getBakiGcr($id, $layak->layak_mula, $layak->layak_tamat);
        if ($layak->layak_cuti  < 20) {
            $check = $layak->layak_cuti + $layak->layak_bawa_lepas;

        } else {
            if ($layak->layak_cuti  >= 30) {
                $check = 15;
            } elseif ($layak->layak_cuti == 25) {
                $check = 12;
            } elseif ($layak->layak_cuti  == 0) {
                $check = $layak->layak_bawa_lepas;
            } else {
                $check = floor(($layak->layak_cuti) / 2);
            }
        }
        // $check = ($this->layak_cuti) / 2;
        // var_dump($lyk->layak_cuti);die;
        $gcr = Layak::getTotalGcr($layak->layak_icno, 0);
        // $value = 60 - $gcr;
        $value = 150 - $gcr;
        if ($this->gcr_applied > ($bal)) {
            $this->addError($attribute, 'GCR Tidak Boleh Melebihi ' . floor($bal) . '.');
        }
        if ($this->gcr_applied > $check) {
            $this->addError($attribute, 'GCR Tidak Boleh Melebihi ' . floor($check) . '.');
        }
        if ($gcr >= 150) {
            if ($this->gcr_applied > 0) {

                $this->addError($attribute, 'Jumlah GCR Anda Sudah Mencapai 150. Sila Masukkan Angka 0 di Ruangan GCR');
            }
        }
        if (($value) < $this->gcr_applied) {
            $this->addError($attribute, 'Anda Cuma Boleh Memohon GCR Sebanyak '.$value.'. Jumlah GCR Terkumpul anda Adalah '.$gcr.'.');
        }
    }

    public function checkCbth($attribute, $params)
    {
        $id = Yii::$app->user->getId();
        $data = date('m');
        // $check = 40;

        // $model = new GcrApplication();
        // if ($data == '01') {
        // $curr_yr = date('Y', strtotime('-1 year'));
        // } else {
            $curr_yr = date('Y');
        // }
        $tmt = $curr_yr . '-12-31';

        $layak = Layak::find()->where(['layak_icno' => $id])->andWhere(['layak_tamat' => $tmt])->one();
        // var_dump($tmt);die;
        $bal = Layak::getBakiGcr($id, $layak->layak_mula, $layak->layak_tamat);

        if ($layak->layak_cuti  <= 20) {
            $check = 40;
        } else
        if ($layak->layak_cuti  == 20) {
            $check = 40;
        } else
        if ($layak->layak_cuti  == 25) {
            $check = 50;
        } else
        if ($layak->layak_cuti  == 30) {
            $check = 60;
        } else
        if ($layak->layak_cuti  >= 35) {
            $check = 70;
        } else {
            $check = 50;
        }
        $total = $this->gcr_applied + $this->cbth_applied;

        // $check = ($this->layak_cuti) / 2;
        // var_dump($lyk->layak_cuti);die;
        if ($this->cbth_applied > ($bal)) {
            $this->addError($attribute, 'CBTH Tidak Boleh Melebihi ' . floor($bal) . '.');
        }
        if ($this->cbth_applied > $check) {
            $this->addError($attribute, 'CBTH Tidak Boleh Melebihi ' . $check . '.');
        }
        if ($total != 0) {
            // if ($bal > $total) {
            //     $this->addError($attribute, 'Sila Pastikan jumlah CBTH + GCR = ' . $bal . '.');
            // }
            if ($bal < $total) {
                $this->addError($attribute, 'Sila Pastikan jumlah CBTH + GCR Tidak Melebihi ' . $bal . '.');
            }
        }
    }
    public function checkTotal($attribute, $params)
    {

        // $lyk = 
        $id = Yii::$app->user->getId();
        $data = date('m');

        // $model = new GcrApplication();
        // if ($data == '12') {
        $curr_yr = date('Y', strtotime('-1 year'));
        // } else {
        //     $curr_yr = date('Y');
        // }
        $tmt = $curr_yr . '-12-31';

        $layak = Layak::find()->where(['layak_icno' => $id])->andWhere(['layak_tamat' => $tmt])->one();
        $bal = Layak::getBakiGcr($id, $layak->layak_mula, $layak->layak_tamat);
        // Layak::findOne(['layak_id' => $this->layak_id]);
        // $check = Layak::getBakiLast($this->layak_id);
        $total = $this->gcr_applied + $this->cbth_applied;
        // var_dump($lyk->layak_cuti);die;

        if ($total != 0) {
            if ($bal > $total) {
                $this->addError($attribute, 'Sila Pastikan jumlah CBTH + GCR + Lupus = ' . $bal . '.');
            }
            if ($bal < $total) {
                $this->addError($attribute, 'Sila Pastikan jumlah CBTH + GCR + Lupus Tidak Melebihi ' . $bal . '.');
            }
        }
    }

    public function getKakitangan()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'pemohon_icno']);
    }
    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'dept_id']);
    }
    public function getTarikhMohon()
    {

        return $this->changeDateFormat($this->mohon_dt);
    }
    public function changeDateFormat($date)
    {

        $dt = date_create($date);

        $v = date_format($dt, "d/m/Y");

        return $v;
    }
}
