<?php

namespace app\models\kehadiran;

use Yii;
use app\models\hronline\Tblprcobiodata;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use app\models\kehadiran\Tblstaff;
use app\models\kehadiran\Tblshift;
use Exception;

/**
 * This is the model class for table "tbl_wp".
 *
 * @property int $id
 * @property int $wp_id ref_wp (id)
 * @property string $icno icno pemohon
 * @property string $remark
 * @property string $entry_dt
 * @property string $ver_by
 * @property string $ver_dt
 * @property string $ver_remark
 * @property string $app_by
 * @property string $app_dt
 * @property string $app_remark
 * @property string $start_date
 * @property string $end_date
 * @property string $status ENTRY, VERIFIED, APPROVED, REJECTED
 *
 * @property RefWp $wp
 */
class TblWp extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attendance.tbl_wp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['wp_id', 'icno', 'remark', 'start_date', 'entry_dt'], 'required'],
            [['wp_id'], 'integer'],
            [['entry_dt', 'ver_dt', 'app_dt', 'start_date', 'end_date'], 'safe'],
            [['icno', 'ver_by', 'app_by'], 'string', 'max' => 12],
            [['remark', 'ver_remark', 'app_remark'], 'string', 'max' => 100],
            [['status'], 'string', 'max' => 8],
            [['wp_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefWp::className(), 'targetAttribute' => ['wp_id' => 'id']],
        ];
    }

    //untuk convert date
    public function behaviors()
    {
        return [
            'start_date' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['start_date'], // update 1 attribute 'created' OR multiple attribute ['created','updated']
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['start_date'], // update 1 attribute 'created' OR multiple attribute ['created','updated']
                ],
                'value' => function ($event) {
                    return date('Y-m-d', strtotime(str_replace("/", "-", $this->start_date)));
                },
            ],
            'end_date' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['end_date'], // update 1 attribute 'created' OR multiple attribute ['created','updated']
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['end_date'], // update 1 attribute 'created' OR multiple attribute ['created','updated']
                ],
                'value' => function ($event) {
                    return $this->end_date ? date('Y-m-d', strtotime(str_replace("/", "-", $this->end_date))) : NULL;
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'wp_id' => 'Wp ID',
            'icno' => 'Icno',
            'remark' => 'Remark',
            'entry_dt' => 'Entry Dt',
            'ver_by' => 'Ver By',
            'ver_dt' => 'Ver Dt',
            'ver_remark' => 'Ver Remark',
            'app_by' => 'App By',
            'app_dt' => 'App Dt',
            'app_remark' => 'App Remark',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'status' => 'Status',
        ];
    }

    //    public function beforeDate($attribute, $params){
    //            $mohon_date = date($this->entry_dt);
    //            
    //            if(!$mohon_date){
    //                $this->addError($attribute, 'Anda Harus Mohon Sebelum atau pada 21 hari bulan!');
    //            }
    //    }

    public function getTarikh($bulan)
    {

        $m = date_format(date_create($bulan), "m");
        if ($m == 01) {
            $m = "Januari";
        } elseif ($m == 02) {
            $m = "Februari";
        } elseif ($m == 03) {
            $m = "Mac";
        } elseif ($m == 04) {
            $m = "April";
        } elseif ($m == 05) {
            $m = "Mei";
        } elseif ($m == 06) {
            $m = "Jun";
        } elseif ($m == 07) {
            $m = "Julai";
        } elseif ($m == '08') {
            $m = "Ogos";
        } elseif ($m == '09') {
            $m = "September";
        } elseif ($m == '10') {
            $m = "Oktober";
        } elseif ($m == '11') {
            $m = "November";
        } elseif ($m == '12') {
            $m = "Disember";
        }

        return date_format(date_create($bulan), "d") . ' ' . $m . ' ' . date_format(date_create($bulan), "Y");
    }

    public function getTarikhMohons()
    {
        return $this->getTarikh($this->entry_dt);
    }

    public function getTarikhMulas()
    {
        return $this->getTarikh($this->start_date);
    }

    public function getTarikhTamats()
    {
        return $this->getTarikh($this->end_date);
    }

    public function getTarikhMohon()
    {
        return $this->entry_dt ? date('d/m/Y', strtotime($this->entry_dt)) : '-';
    }

    public function getTarikhMula()
    {
        return $this->entry_dt ? date('d/m/Y', strtotime($this->start_date)) : '-';
    }

    public function getTarikhTamat()
    {
        return $this->end_date ? date('d/m/Y', strtotime($this->end_date)) : '-';
    }

    public function getStatusLabel()
    {
        if ($this->status == 'ENTRY') {
            return '<span class="label label-warning">ENTRY</span>';
        }

        if ($this->status == 'VERIFIED') {
            return '<span class="label label-primary">VERIFIED</span>';
        }

        if ($this->status == 'APPROVED') {
            return '<span class="label label-success">APPROVED</span>';
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWp()
    {
        return $this->hasOne(RefWp::className(), ['id' => 'wp_id']);
    }

    public function getKakitangan()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }

    /**
     * Utk dapatkan current WP;
     */
    public static function curr_wp_old($icno, $display = null)
    {

        $val = '';

        $sql = 'SELECT * FROM attendance.tbl_wp WHERE icno=:icno AND status=:status AND (DATE(NOW()) BETWEEN start_date AND end_date OR end_date IS NULL)';
        $model = TblWp::findBySql($sql, [':icno' => $icno, ':status' => 'APPROVED'])->one();

        //        $model = TblWp::find()->where(['icno' => $icno, 'status' => 'APPROVED'])->orderBy('id DESC')->one();
        //if ada return wp_id
        if ($model) {
            $val = $model->wp_id;

            if ($display) {
                $val = $model->wp->jenis_wp;
            }
        }

        return $val;
    }

    public static function curr_wp($icno, $display = null)
    {

        $val = '';
        $today = date('Y-m-d');

        $staff = Tblstaff::find()->where(['staff_icno' => $icno])->one();

        $sql = 'SELECT * FROM attendance.tbl_wp WHERE icno=:icno AND status=:status AND (DATE(NOW()) BETWEEN start_date AND end_date OR end_date IS NULL)';
        $model = TblWp::findBySql($sql, [':icno' => $icno, ':status' => 'APPROVED'])->one();

        $bio = Tblprcobiodata::find()->where(['icno' => $icno])->one();

        $isRamadhan = self::betweenDates($today, '2022-04-03', '2022-05-03');


        //check dlu klu ada dlm staf list utk shift
        if ($staff) {
            try {
                $shift = Tblshift::find()->where(['icno' => $icno, 'tarikh' => $today])->one();

                if ($shift) {
                    $val = $display ? $model->wp->jenis_wp : $shift->wp_id;
                } else {
                    if ($bio->ReligionCd == "01" && $model->wp_id == 40 && $isRamadhan == true) {
                        $val = $display ? 'WBFR' : 49;
                    } else {
                        $val = $display ? $model->wp->jenis_wp : $model->wp_id;
                    }
                }
            } catch (Exception $e) {
                echo '--Tiada WBB--';
            }

            //klu tiada pakai yang wbb biasa sja
        } else {

            if ($model) {

                //sementara pakai utk bulan ramadhan 
                //if muslim and WBF autmatik trus tukar ke ramadhan
                if ($bio->ReligionCd == "01" && $model->wp_id == 40 && $isRamadhan == true) {
                    $val = $display ? 'WBFR' : 49;
                } else {
                    $val = $display ? $model->wp->jenis_wp : $model->wp_id;
                }
            } else {
                $val = '';
            }
        }

        return $val;
    }

    public static function betweenDates($cmpDate, $startDate, $endDate)
    {
        if ((date($cmpDate) >= date($startDate)) && (date($cmpDate) <= date($endDate))) {
            return true;
        }

        return false;
    }
}
