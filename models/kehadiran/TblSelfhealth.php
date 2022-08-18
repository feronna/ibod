<?php

namespace app\models\kehadiran;

use Yii;
use app\models\hronline\Tblprcobiodata;
use app\models\kehadiran\TblWfh;
use app\models\hronline\TempPpv;

/**
 * This is the model class for table "tbl_selfhealth".
 *
 * @property int $id
 * @property string $icno
 * @property string $date
 * @property int $health_status
 * @property string $temperature
 * @property string $status
 * @property string $comment
 */
class TblSelfhealth extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'attendance.tbl_selfhealth';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'health_status'], 'integer'],
            [['date', 'status_prw', 'treatment_place'], 'safe'],
            [['icno'], 'string', 'max' => 14],
            [['temperature', 'status'], 'string', 'max' => 20]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'date' => 'Date',
            'health_status' => 'Health Status',
            'temperature' => 'Temperature',
            'status' => 'Status',
            'comment' => 'Comment',
        ];
    }

    public static function checktoday() {
        $icno = Yii::$app->user->getId();

        $today = date('Y-m-d');

//        $check = self::find()->where(['icno' => $icno])->orderBy(['id' => SORT_DESC])->one();
        if (TblWfh::getStatusWfh($icno, $today)) {
            $check = true;
        } else {
            $check = self::find()->where(['icno' => $icno, 'DATE(date)' => $today])->exists() ? true : false;
        }
        return $check;
    }

    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }

    public function getStatusprw() {
        if ($this->status_prw) {
            return $this->status_prw === 'Allow to work' ? '<span class="btn" style="font-size:11px; width: 130px;background-color: green; color:white"><i class="fa fa-suitcase"></i> Allowed to work</span>' : '<span class="btn btn-danger" style="font-size:11px; width: 130px;"><i class="fa fa-suitcase"></i> Not allowed to work</span>';
        } else {
            return '';
        }
    }

    public function getPlaces() {
        if ($this->treatment_place) {
            return $this->treatment_place === 'prw' ? '<span class="btn btn-info" style="font-size:10px; width: 130px;"><i class="fa fa-hospital-o"></i> PRW / <br>Klinik Rawatan UMS</span>' : '<span class="btn btn-warning"  style="font-size:10px; width: 130px;"><i class="fa fa-hospital-o"></i> Klinik Panel UMS/<br>Hospital/Lain-lain klinik</span>';
        } else {
            return '';
        }
    }

    public function getSuhu() {
        if ($this->temperature > 37.5 || $this->temperature == '> 37.5') {
            return '<span class="label label-danger">' . $this->temperature . '</span>';
        } else {
            return '<span class="label label-success">' . $this->temperature . '</span>';
        }
    }

    public static function campus($id, $date, $jfpib) {
        $biodata = $jfpib ? Tblprcobiodata::find()->where(['DeptId' => $jfpib, 'Status' => 1, 'Campus_id' => $id]) : Tblprcobiodata::find()->where(['Status' => 1, 'Campus_id' => $id]);

        return TblSelfhealth::find()->where(['like', 'date', date_format(date_create($date), 'Y-m-d')])->andWhere(['icno' => $biodata->select(['ICNO'])])->all();
    }

    public static function kampus($id, $date, $jfpib) {
        $biodata = $jfpib ? Tblprcobiodata::find()->where(['DeptId' => $jfpib, 'Status' => 1, 'Campus_id' => $id]) : Tblprcobiodata::find()->where(['Status' => 1, 'Campus_id' => $id]);

        return TblWfh::find()->where(['like', 'start_date', date_format(date_create($date), 'Y-m-d')])->andWhere(['icno' => $biodata->select(['ICNO'])])->all();
    }

    public static function totalWfh($date, $campus, $jfpiu) {
        $staff = $campus ? Tblprcobiodata::find()->where(['Status' => 1, 'campus_id' => $campus]) : Tblprcobiodata::find()->where(['Status' => 1]);
        $staff = $jfpiu ? $staff->andWhere(['DeptId' => $jfpiu]) : $staff;

        $count = TblWfh::find()->where(['start_date' => $date])->andWhere(['icno' => $staff->select(['ICNO']), 'status' => 'APPROVED'])->count();

        return $count;
    }

    public static function totalWfhPkpd($date, $campus, $jfpiu) {
        $staff = $campus ? Tblprcobiodata::find()->where(['Status' => 1, 'campus_id' => $campus]) :
                Tblprcobiodata::find()->where(['Status' => 1]);
        $staff = $jfpiu ? $staff->andWhere(['DeptId' => $jfpiu]) : $staff;

        $ppv = \app\models\hronline\TempPpv::find()->all();
        foreach ($ppv as $ppv) {
            $icno[] = $ppv->icno;
        }
        $count = TblWfh::find()
                ->joinWith('kakitangan')
                ->where(['start_date' => $date])
                ->andWhere(['icno' => $staff->select(['ICNO']), 'status' => 'APPROVED'])
                ->andWhere(['!=', 'tblprcobiodata.DeptId', 164])
                ->count();

        return $count;
    }

    public static function totalWfhLabuan($date, $campus, $jfpiu) {
        $staff_lbu_wfh = 0;

        $lbu_wfh_icno = TblWfh::find()->select('icno')->where(['start_date' => $date, 'status' => "APPROVED"])->asArray()->all();
        $lbu_wfh_icno_array = [];
        for ($i = 0; $i < count($lbu_wfh_icno); $i++) {
            array_push($lbu_wfh_icno_array, $lbu_wfh_icno[$i]['icno']);
        }



        $staff_lbu_wfh = Tblprcobiodata::find()->joinWith('jawatan')
                ->where(['AND', ['IN', 'ICNO', $lbu_wfh_icno_array], ['NOT IN', 'Status', [6, 2, 3, 4, 5]]])
                ->andWhere(['NOT IN', 'gred_skim', ['KP', 'GV', 'G']])
                ->andWhere(['!=', 'DeptId', '164'])
                ->andWhere(['campus_id' => '2'])
                ->count();

        return $staff_lbu_wfh;
    }

    public static function totalWfhSandakan($date, $campus, $jfpiu) {
        $staff_lbu_wfh = 0;
        $lbu_wfh_icno = TblWfh::find()->select('icno')->where(['start_date' => $date, 'status' => "APPROVED"])->asArray()->all();
        $lbu_wfh_icno_array = [];
        for ($i = 0; $i < count($lbu_wfh_icno); $i++) {
            array_push($lbu_wfh_icno_array, $lbu_wfh_icno[$i]['icno']);
        }



        $staff_lbu_wfh = Tblprcobiodata::find()->joinWith('jawatan')
                ->where(['AND', ['IN', 'ICNO', $lbu_wfh_icno_array], ['NOT IN', 'Status', [6, 2, 3, 4, 5]]])
                ->andWhere(['NOT IN', 'gred_skim', ['KP', 'GV', 'G']])
                ->andWhere(['NOT LIKE', 'fname', ['adjung']])
                ->andWhere(['NOT LIKE', 'fname', ['pemandu']])
                ->andWhere(['!=', 'DeptId', '164'])
                ->andWhere(['campus_id' => '3'])
                ->count();

        return $staff_lbu_wfh;
    }

    public static function totalBdr($date, $campus, $jfpiu) {
        $staff_kk_wfh = 0;
        $now = date('Y-m-d');
//       $staff = $campus ? Tblprcobiodata::find()->where(['Status' => 1, 'campus_id' => $campus]) : Tblprcobiodata::find()->where(['Status' => 1]);
//        $staff = $jfpiu ? $staff->andWhere(['DeptId' => $jfpiu]) : $staff;
        $kk_wfh_icno = TblWfh::find()->select('icno')->where(['start_date' => $date, 'status' => "APPROVED"])->asArray()->all();
        $kk_wfh_icno_array = [];
        for ($i = 0; $i < count($kk_wfh_icno); $i++) {
            array_push($kk_wfh_icno_array, $kk_wfh_icno[$i]['icno']);
        }

        $sukarelawan_ppv = TempPpv::find()->select('icno')->asArray()->all();
        $icno_sukarelawan_ppv = [];
        for ($i = 0; $i < count($sukarelawan_ppv); $i++) {
            array_push($icno_sukarelawan_ppv, $sukarelawan_ppv[$i]['icno']);
        }
        $pemandu_HEP = ['720803125153', '730219125217', '721113125097'];

        $staff_kk_wfh = Tblprcobiodata::find()->joinWith('jawatan')
                ->where(['AND', ['IN', 'ICNO', $kk_wfh_icno_array], ['NOT IN', 'Status', [6, 2, 3, 4, 5]]])
                ->andWhere(['NOT IN', 'gred_skim', ['KP', 'GV', 'G']])
                ->andWhere(['!=', 'DeptId', '164'])
                ->andWhere(['NOT IN', 'ICNO', $icno_sukarelawan_ppv])
                ->andWhere(['NOT IN', 'ICNO', $pemandu_HEP])
                ->andWhere(['campus_id' => '1'])
//        ->andWhere([$kk_wfh_icno=>'start_date'])
                ->count();

        return $staff_kk_wfh;
    }

    public static function totalWfoKk($date) {
//        $kk_wfo_icno = TblWfh::find()->select('icno')->where(['start_date' => $date])->asArray()->all();
//        $kk_wfo_icno_array = [];
//        for ($i = 0; $i < count($kk_wfo_icno); $i++) {
//            array_push($kk_wfo_icno_array, $kk_wfo_icno[$i]['icno']);
//        }
        $kk_wfo_icno = TblWfh::find()->select('icno')->where(['start_date' => $date])->all();
        foreach ($kk_wfo_icno as $kk_wfo_icno_array) {
            $ICNO[] = $kk_wfo_icno_array->icno;
        }
//        $sukarelawan_ppv = TempPpv::find()->select('icno')->asArray()->all();
//        $icno_sukarelawan_ppv = [];
//        for ($i = 0; $i < count($sukarelawan_ppv); $i++) {
//            array_push($icno_sukarelawan_ppv, $sukarelawan_ppv[$i]['icno']);
//        }
        $sukarelawan_ppv = TempPpv::find()->select('icno')->all();
        foreach ($sukarelawan_ppv as $sukarelawan_ppv) {
            $vol[] = $sukarelawan_ppv->icno;
        }
        $pemandu_HEP = ['720803125153', '730219125217', '721113125097'];
        $staff_kk_wfo = Tblprcobiodata::find()->joinWith('jawatan')
                ->where(['NOT IN', 'ICNO', $ICNO])
                ->andWhere(['NOT IN', 'Status', [6, 2, 3, 4, 5]])
                ->andWhere(['NOT IN', 'gred_skim', ['KP', 'GV', 'G']])
                ->andWhere(['!=', 'DeptId', '164'])
                ->andWhere(['NOT IN', 'ICNO', $vol])
                ->andWhere(['NOT IN', 'ICNO', $pemandu_HEP])
                ->andWhere(['campus_id' => '1'])
                ->count();
//        var_dump($staff_kk_wfo);die;
        return $staff_kk_wfo;
    }

    public static function totalNonEssentialKk($date, $campus, $jfpiu) {
//        $kk_wfo_icno = TblWfh::find()->select('icno')->where(['status' => "APPROVED"])->asArray()->all();
//        $kk_wfo_icno_array = [];
//        for ($i = 0; $i < count($kk_wfo_icno); $i++) {
//            array_push($kk_wfo_icno_array, $kk_wfo_icno[$i]['icno']);
//        }
        $sukarelawan_ppv = TempPpv::find()->select('icno')->asArray()->all();
        $icno_sukarelawan_ppv = [];
        for ($i = 0; $i < count($sukarelawan_ppv); $i++) {
            array_push($icno_sukarelawan_ppv, $sukarelawan_ppv[$i]['icno']);
        }
        $pemandu_HEP = ['720803125153', '730219125217', '721113125097'];
        $staff_kk_wfo = Tblprcobiodata::find()->joinWith('jawatan')
                ->where(['AND', ['NOT IN', 'Status', [6, 2, 3, 4, 5]]])
                ->andWhere(['NOT IN', 'gred_skim', ['KP', 'GV', 'G']])
                ->andWhere(['!=', 'DeptId', '164'])
                ->andWhere(['NOT IN', 'ICNO', $icno_sukarelawan_ppv])
                ->andWhere(['NOT IN', 'ICNO', $pemandu_HEP])
                ->andWhere(['campus_id' => '1'])
                ->count();

        return $staff_kk_wfo;
    }

    public static function totalNonEssentialSdk($date, $campus, $jfpiu) {

        $staff_kk_wfo = Tblprcobiodata::find()->joinWith('jawatan')
                ->where(['AND', ['NOT IN', 'Status', [6, 2, 3, 4, 5]]])
                ->andWhere(['NOT IN', 'gred_skim', ['KP', 'GV', 'G']])
                ->andWhere(['!=', 'DeptId', '164'])
                ->andWhere(['NOT LIKE', 'fname', ['adjung']])
                ->andWhere(['NOT LIKE', 'fname', ['pemandu']])
                ->andWhere(['NOT LIKE', 'fname', ['(H11) pembantu awam']])
                ->andWhere(['campus_id' => '3'])
                ->count();

        return $staff_kk_wfo;
    }

    public static function totalNonEssentialLbu($date, $campus, $jfpiu) {

        $staff_kk_wfo = Tblprcobiodata::find()->joinWith('jawatan')
                ->where(['AND', ['NOT IN', 'Status', [6, 2, 3, 4, 5]]])
                ->andWhere(['NOT IN', 'gred_skim', ['KP', 'GV', 'G']])
                ->andWhere(['!=', 'DeptId', '164'])
                ->andWhere(['campus_id' => '2'])
                ->count();

        return $staff_kk_wfo;
    }

    public static function totalWfoLabuan($date) {
//        $lbu_wfo_icno = TblWfh::find()->select('icno')->where(['start_date' => $date])->asArray()->all();
//        $lbu_wfo_icno_array = [];
//        for ($i = 0; $i < count($lbu_wfo_icno); $i++) {
//            array_push($lbu_wfo_icno_array, $lbu_wfo_icno[$i]['icno']);
//        }
        $lbu_wfo_icno = TblWfh::find()->select('icno')->where(['start_date' => $date])->all();
        foreach ($lbu_wfo_icno as $lbu_wfo_icno_array) {
            $ICNO[] = $lbu_wfo_icno_array->icno;
        }

        $staff_lbu_wfo = Tblprcobiodata::find()->joinWith('jawatan')
                ->where(['AND', ['NOT IN', 'ICNO', $ICNO], ['NOT IN', 'Status', [6, 2, 3, 4, 5]]])
                ->andWhere(['NOT IN', 'gred_skim', ['KP', 'GV', 'G']])
                ->andWhere(['!=', 'DeptId', '164'])
                ->andWhere(['campus_id' => '2'])
                ->count();

        return $staff_lbu_wfo;
    }

    public static function totalWfoKudat($date) {
//        $lbu_wfo_icno = TblWfh::find()->select('icno')->where(['start_date' => $date])->asArray()->all();
//        $lbu_wfo_icno_array = [];
//        for ($i = 0; $i < count($lbu_wfo_icno); $i++) {
//            array_push($lbu_wfo_icno_array, $lbu_wfo_icno[$i]['icno']);
//        }
        $lbu_wfo_icno = TblWfh::find()->select('icno')->where(['start_date' => $date])->all();
        foreach ($lbu_wfo_icno as $lbu_wfo_icno_array) {
            $ICNO[] = $lbu_wfo_icno_array->icno;
        }

        $staff_lbu_wfo = Tblprcobiodata::find()->joinWith('jawatan')
                ->where(['AND', ['NOT IN', 'ICNO', $ICNO], ['NOT IN', 'Status', [6, 2, 3, 4, 5]]])
                ->andWhere(['NOT IN', 'gred_skim', ['KP', 'GV', 'G']])
                ->andWhere(['!=', 'gred', ['J19']])
                ->andWhere(['!=', 'DeptId', '164'])
                ->andWhere(['NOT LIKE', 'fname', ['pemandu']])
                ->andWhere(['campus_id' => '4'])
                ->count();

        return $staff_lbu_wfo;
    }

    public static function totalWfoSandakan($date) {
//        $sdk_wfo_icno = TblWfh::find()->select('icno')->where(['start_date' => $date])->asArray()->all();
//        $sdk_wfo_icno_array = [];
//        for ($i = 0; $i < count($sdk_wfo_icno); $i++) {
//            array_push($sdk_wfo_icno_array, $sdk_wfo_icno[$i]['icno']);
//        }
        $sdk_wfo_icno = TblWfh::find()->select('icno')->where(['start_date' => $date])->all();
        foreach ($sdk_wfo_icno as $sdk_wfo_icno_array) {
            $ICNO[] = $sdk_wfo_icno_array->icno;
        }

        $staff_sdk_wfo = Tblprcobiodata::find()->joinWith('jawatan')
                ->where(['AND', ['NOT IN', 'ICNO', $ICNO], ['NOT IN', 'Status', [6, 2, 3, 4, 5]]])
                ->andWhere(['NOT IN', 'gred_skim', ['KP', 'GV', 'G']])
                ->andWhere(['!=', 'DeptId', '164'])
                ->andWhere(['campus_id' => '3'])
                ->andWhere(['NOT LIKE', 'fname', ['adjung']])
                ->andWhere(['NOT LIKE', 'fname', ['pemandu']])
                ->andWhere(['NOT LIKE', 'fname', ['(H11) pembantu awam']])
                ->count();

        return $staff_sdk_wfo;
    }

}
