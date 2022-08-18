<?php

namespace app\models\survey;

use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use app\models\hronline\Adminposition;
use app\models\hronline\Department;
use app\models\hronline\ProgramPengajaran;
use Exception;

/**
 * This is the model class for table "hrm.survey_tbl_aktiviti".
 *
 * @property int $id
 * @property int $adminpos_id adminpostion id
 * @property int $program_id programpengajaran id
 * @property int $dept_id Department id
 * @property string $nama
 * @property string $catatan
 * @property string $full_date
 * @property string $start_dt Tarikh/Masa Mula
 * @property string $end_dt Tarikh/Masa Tamat
 * @property int $status Aktif / X aktif
 * @property string $create_by
 * @property string $create_dt
 * @property string $update_by
 * @property string $update_dt
 */
class TblAktiviti extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.survey_tbl_aktiviti';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['adminpos_id', 'dept_id', 'catatan', 'nama', 'full_date', 'start_dt', 'end_dt'], 'required'],
            [['adminpos_id', 'program_id', 'dept_id', 'status'], 'integer'],
            [['catatan'], 'string'],
            [['start_dt', 'end_dt', 'create_dt', 'update_dt', 'program_id'], 'safe'],
            [['full_date'], 'string', 'max' => 50],
            [['create_by', 'update_by'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'adminpos_id' => 'Jawatan Pentadbiran',
            'program_id' => 'Program Pengajaran',
            'dept_id' => 'JFPIB',
            'nama' => 'Nama Aktiviti',
            'catatan' => 'Catatan',
            'full_date' => 'Tarikh / Masa (Mula - Tamat)',
            'start_dt' => 'Tarikh/Masa Mula',
            'end_dt' => 'Tarikh/Masa Tamat',
            'status' => 'Status',
            'create_by' => 'Dibuat oleh',
            'create_dt' => 'Aktiviti dibuat pada',
            'update_by' => 'Dikemaskini oleh',
            'update_dt' => 'Aktiviti dikemaskini pada',
            'statusText' => 'Status',
            'programText' => 'Program Pengajaran',
        ];
    }

    //untuk convert date
    public function behaviors()
    {
        return [
            'start_dt' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['start_dt'], // update 1 attribute 'created' OR multiple attribute ['created','updated']
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['start_dt'], // update 1 attribute 'created' OR multiple attribute ['created','updated']
                ],
                'value' => function ($event) {
                    return date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $this->start_dt)));
                },
            ],
            'end_dt' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['end_dt'], // update 1 attribute 'created' OR multiple attribute ['created','updated']
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['end_dt'], // update 1 attribute 'created' OR multiple attribute ['created','updated']
                ],
                'value' => function ($event) {
                    return date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $this->end_dt)));
                },
            ],
        ];
    }

    public function getStatusText()
    {
        return $this->status == 1 ? 'Aktif' : 'Tidak Aktif';
    }

    public function getProgramText()
    {

        if ($this->program_id) {
            return $this->programPengajaran->KodProgram . ' - ' . $this->programPengajaran->NamaProgram;
        }

        return '-';
    }

    public function getAdminPos()
    {
        return Adminposition::find()->where(['position_type' => 1])->all();
    }

    public function getDepartment()
    {
        return Department::findAll(['isActive' => '1']);
    }

    public function getProgram()
    {
        return ProgramPengajaran::find()->all();
    }

    public function getAdminPosition()
    {
        return $this->hasOne(Adminposition::className(), ['id' => 'adminpos_id']);
    }

    public function getRelPengundi()
    {
        return $this->hasOne(TblPengundi::className(), ['aktiviti_id' => 'id']);
    }

    public function getProgramPengajaran()
    {
        if ($this->program_id) {
            return $this->hasOne(ProgramPengajaran::className(), ['id' => 'program_id']);
        }

        return null;
    }

    public function getJfpib()
    {
        return $this->hasOne(Department::className(), ['id' => 'dept_id']);
    }

    public function getTarikhMula()
    {
        return date('d/m/Y', strtotime(str_replace("-", "/", $this->start_dt)));
    }

    public function getTarikhTamat()
    {
        return date('d/m/Y', strtotime(str_replace("-", "/", $this->end_dt)));
    }

    public function getTotalVoted()
    {
        return TblPengundi::find()->where(['aktiviti_id' => $this->id, 'vote_status' => 1])->count();
    }

    public function getTotalVoters()
    {
        return TblPengundi::find()->where(['aktiviti_id' => $this->id])->count();
    }

    public function getPeratusUndi()
    {

        $peratus = 0;

        try {
            $peratus = round(($this->getTotalVoted() / $this->getTotalVoters()) * 100, 2);
        } catch (Exception $e) {
            //echo $e->getMessage();
        }


        return $peratus;
    }
}
