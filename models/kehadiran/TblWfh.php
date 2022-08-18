<?php

namespace app\models\kehadiran;


use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use app\models\hronline\Tblprcobiodata;
use app\models\cuti\AksesPengguna;
use DateTime;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "attendance.tbl_wfh".
 *
 * @property int $id
 * @property string $icno
 * @property string $full_date
 * @property string $start_date
 * @property string $end_date
 * @property int $tempoh
 * @property string $remark
 * @property string $entry_dt
 * @property string $ver_by
 * @property string $ver_dt
 * @property string $app_by
 * @property string $app_dt
 * @property string $status ENTRY,REJECTED,VERIFIED,APPROVED
 */
class TblWfh extends \yii\db\ActiveRecord
{

    public $file;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attendance.tbl_wfh';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start_date', 'end_date', 'entry_dt', 'ver_dt', 'app_dt', 'tempoh', 'icno'], 'safe'],
            [['ver_by', 'app_by'], 'string', 'max' => 12],
            [['wfh_reason_id'], 'integer'],
            // [['icno'], 'string', 'max' => 30],
            [['full_date', 'doc_name'], 'string', 'max' => 100],
            [['full_date'], 'checkDate', 'on' => 'mohon'],
            [['wfh_reason_id', 'full_date', 'remark', 'file'], 'required', 'on' => 'mohon', 'message' => 'Ruangan ini wajib diisi!'],
            [['status'], 'required', 'on' => 'kelulusan', 'message' => 'Ruangan ini wajib diisi!'],
            [['hashcode'], 'string', 'max' => 255],
            [['file'], 'file', 'maxSize' => 2000 * 1024, 'tooBig' => 'File Limit is 2MB only'],
            [['status'], 'string', 'max' => 10],
        ];
    }

    //untuk convert date
    public function behaviors()
    {
        return [
            'start_dt' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['start_date'], // update 1 attribute 'created' OR multiple attribute ['created','updated']
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['start_date'], // update 1 attribute 'created' OR multiple attribute ['created','updated']
                ],
                'value' => function ($event) {
                    return date('Y-m-d', strtotime(str_replace("/", "-", $this->start_date)));
                },
            ],
            'end_dt' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['end_date'], // update 1 attribute 'created' OR multiple attribute ['created','updated']
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['end_date'], // update 1 attribute 'created' OR multiple attribute ['created','updated']
                ],
                'value' => function ($event) {
                    return date('Y-m-d', strtotime(str_replace("/", "-", $this->end_date)));
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
            'icno' => 'Nama Kakitangan',
            'full_date' => 'Tarikh (Dari - Hingga)',
            'start_date' => 'Tarikh Mula',
            'end_date' => 'Tarikh Tamat',
            'tempoh' => 'Tempoh',
            'remark' => 'Butiran / Keterangan Permohonan',
            'entry_dt' => 'Tarikh/Masa Permohonan',
            'ver_by' => 'Ketua Jabatan',
            'ver_remark' => 'Catatan Perakuan',
            'ver_dt' => 'Tarikh/Masa Per',
            'app_by' => 'Tindakan Kelulusan',
            'app_dt' => 'Tarikh/Masa Kelulusan',
            'app_remark' => 'Catatan Kelulusan',
            'status' => 'Status Permohonan',
            'wfh_reason_id' => 'Sebab / Alasan',
            'file' => 'Lampiran / Surat / Bukti',
        ];
    }

    public function getKakitangan()
    {
        return $this->hasOne(Tblprcobiodata::class, ['ICNO' => 'icno']);
    }

    public function getPeraku()
    {
        return $this->hasOne(Tblprcobiodata::class, ['ICNO' => 'ver_by']);
    }

    public function checkDate($attribute, $params)
    {
        $today = date('Y-m-d');

        $icno = Yii::$app->user->getId();

        $arr = explode(" ", $this->full_date);

        $start_date = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[0]))));
        $end_date = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[2]))));

        $date1 = \date_create($start_date);
        $date2 = \date_create($end_date);
        $diff = \date_diff($date1, $date2);
        $abs_diff = $diff->format("%a") + 1;

        $start_sql = 'SELECT * FROM attendance.tbl_wfh WHERE icno=:icno AND (:date BETWEEN start_date AND end_date) AND status !=:status';
        $start_date_exist = TblWfh::findBySql($start_sql, [':icno' => $icno, ':date' => $start_date, ':status' => 'REJECTED'])->exists();

        $end_sql = 'SELECT * FROM attendance.tbl_wfh WHERE icno=:icno AND (:date BETWEEN start_date AND end_date AND status !=:status)';
        $end_date_exist = TblWfh::findBySql($end_sql, [':icno' => $icno, ':date' => $end_date,  ':status' => 'REJECTED'])->exists();


        if ($start_date_exist) {
            $this->addError($attribute, 'Tarikh mula adalah bertindih dengan permohonan lain!');
        }

        if ($end_date_exist) {
            $this->addError($attribute, 'Tarikh tamat adalah bertindih dengan permohonan lain!');
        }

        if ($abs_diff > 14) {
            $this->addError($attribute, 'Tempoh permohonan wfh melebihi 14 hari');
        }
    }

    public function getTotalDays()
    {


        $date1 = \date_create(\date('Y-m-d', strtotime(str_replace("/", "-", $this->start_date))));
        $date2 = \date_create(\date('Y-m-d', strtotime(str_replace("/", "-", $this->end_date))));
        $diff = \date_diff($date1, $date2);
        return $diff->format("%a") + 1;
    }


    /**
     * $icno : staff icno
     * $tarikh : format yyyy-mm-dd
     *
     * return true : WFH || false : WFO
     *
     */
    public static function getStatusWfh($icno, $tarikh)
    {

        $val = false;

        $sql = 'SELECT * FROM attendance.tbl_wfh WHERE icno=:icno AND :tarikh BETWEEN start_date AND end_date AND status =:status';
        $model = TblWfh::findBySql($sql, [':icno' => $icno, ':tarikh' => $tarikh, ':status' => 'APPROVED'])->one();

        if ($model) {
            $val = true;
        }

        return $val;
    }

    public static function totalWfhByDay($date, $icno)
    {

        $bio = Tblprcobiodata::findOne(['ICNO' => $icno]);

        $staff = Tblprcobiodata::find()->where(['DeptId' => $bio->DeptId])->all();

        $array_own_staff = [];

        foreach ($staff as $r) {
            $array_own_staff[] = $r->ICNO;
        }

        $count = TblWfh::find()
            ->where(['status' => 'APPROVED'])
            ->andFilterWhere(['<=', 'start_date', $date])
            ->andFilterWhere(['>=', 'end_date', $date])
            ->andWhere(['in', 'icno', $array_own_staff])
            ->count();

        return $count;
    }

    public static function wfhByDay($date, $icno, $isdata = 0)
    {

        $staff = AksesPengguna::kakitanganSeliaan($icno);

        $array_own_staff = [];

        foreach ($staff as $r) {
            $array_own_staff[] = $r->ICNO;
        }

        $today_wfh_list = TblWfh::find()
            ->joinWith('kakitangan')
            ->where(['tbl_wfh.status' => 'APPROVED'])
            ->andWhere(['in', 'tbl_wfh.icno', $array_own_staff])
            ->andFilterWhere(['<=', 'start_date', $date])
            ->andFilterWhere(['>=', 'end_date', $date])
            ->orderBy(['tblprcobiodata.CONm' => SORT_ASC])
            ->all();

        if ($isdata == 1) {

            return $today_wfh_list;
        } else {
            return count($today_wfh_list);
        }
    }


    public static function wfhByDayAdmin($date, $icno, $deptId)
    {

        $staff = AksesPengguna::kakitanganSeliaan($icno, null, $deptId);

        $array_own_staff = [];

        foreach ($staff as $r) {
            $array_own_staff[] = $r->ICNO;
        }

        $today_wfh_list = TblWfh::find()->joinWith('kakitangan')->where(['tbl_wfh.start_date' => $date, 'tbl_wfh.status' => 'APPROVED'])->andWhere(['in', 'tbl_wfh.icno', $array_own_staff])->orderBy(['tblprcobiodata.CONm' => SORT_ASC])->all();

        return count($today_wfh_list);
    }

    public static function isWfh($date, $icno)
    {

        $v = 0;

        // $model = TblWfh::find()->select(['id'])->where(['start_date' => $date, 'status' => 'APPROVED', 'icno' => $icno])->one();

        $model = TblWfh::find()
            ->where(['status' => 'APPROVED', 'icno' => $icno])
            ->andFilterWhere(['<=', 'start_date', $date])
            ->andFilterWhere(['>=', 'end_date', $date])
            ->one();

        if ($model) {
            $v = 1;
        }

        return $v;
    }

    public static function totalPendingWfhApproval($icno)
    {
        $count = self::find()
            ->where(['app_by' => $icno, 'status' => 'ENTRY'])
            ->asArray()
            ->count('id');
        return $count;
    }

    public function search($params, $arr_staff = null)
    {
        $query = self::find()
            ->joinWith(['kakitangan'])
            ->where(['>', 'YEAR(start_date)', '2021']) //kenapa 2021? sbb tahun 2022 baru start ada permohonan tq..
            ->andFilterWhere(['IN', 'tbl_wfh.icno', $arr_staff])
            ->andWhere(['NOT LIKE', 'remark', 'ADDED BY PENYELIA']);
        $query->limit(1000);

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
            'tbl_wfh.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'tblprcobiodata.CONm', $this->icno]);

        return $dataProvider;
    }

    public function searchAsPegawai($params, $icno = null)
    {
        $query = self::find()
            ->joinWith(['kakitangan'])
            ->where(['>', 'YEAR(start_date)', '2021']) //kenapa 2021? sbb tahun 2022 baru start ada permohonan tq..
            ->andFilterWhere(['=', 'app_by', $icno])
            ->andWhere(['NOT LIKE', 'remark', 'ADDED BY PENYELIA']);
        $query->orderBy(['entry_dt' => 'DESC']);
        $query->limit(1000);

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
            'tbl_wfh.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'tblprcobiodata.CONm', $this->icno]);

        return $dataProvider;
    }
}
