<?php

namespace app\models\smppasca;

use Yii;

/**
 * This is the model class for table "dbo.ED01_Supervision".
 *
 * @property string $studentMatricNo
 * @property string $studentName
 * @property string $supervisorName
 * @property string $supervisorIC
 * @property string $supervisionType
 * @property string $beginDate
 * @property string $endDate
 * @property string $researchTitle
 * @property string $studentStatus
 * @property int $statusPenyeliaan
 * @property string $gelaran
 * @property int $levelId
 * @property int $statusPlums
 * @property string $modId
 * @property string $modOfStudyName
 * @property string $methodId
 * @property string $methodOfStudyName
 * @property int $Peringkat
 * @property string $ModLevelName
 * @property string $ModFullName
 * @property string $supervisorStafNo
 * @property string $KodSesi_Sem
 */
class PenyeliaanPelajarPasca extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.ED01_Supervision';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db9');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['studentMatricNo', 'supervisorIC', 'supervisorStafNo', 'KodSesi_Sem'], 'required'],
            [['beginDate', 'endDate'], 'safe'],
            [['statusPenyeliaan', 'levelId', 'statusPlums', 'Peringkat'], 'integer'],
            [['studentMatricNo', 'KodSesi_Sem'], 'string', 'max' => 11],
            [['studentName'], 'string', 'max' => 60],
            [['supervisorName'], 'string', 'max' => 150],
            [['supervisorIC'], 'string', 'max' => 14],
            [['supervisionType', 'modOfStudyName', 'methodOfStudyName', 'ModFullName'], 'string', 'max' => 50],
            [['researchTitle'], 'string', 'max' => 250],
            [['studentStatus', 'gelaran'], 'string', 'max' => 40],
            [['modId', 'methodId'], 'string', 'max' => 5],
            [['ModLevelName'], 'string', 'max' => 10],
            [['supervisorStafNo'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'studentMatricNo' => 'Student Matric No',
            'studentName' => 'Student Name',
            'supervisorName' => 'Supervisor Name',
            'supervisorIC' => 'Supervisor Ic',
            'supervisionType' => 'Supervision Type',
            'beginDate' => 'Begin Date',
            'endDate' => 'End Date',
            'researchTitle' => 'Research Title',
            'studentStatus' => 'Student Status',
            'statusPenyeliaan' => 'Status Penyeliaan',
            'gelaran' => 'Gelaran',
            'levelId' => 'Level ID',
            'statusPlums' => 'Status Plums',
            'modId' => 'Mod ID',
            'modOfStudyName' => 'Mod Of Study Name',
            'methodId' => 'Method ID',
            'methodOfStudyName' => 'Method Of Study Name',
            'Peringkat' => 'Peringkat',
            'ModLevelName' => 'Mod Level Name',
            'ModFullName' => 'Mod Full Name',
            'supervisorStafNo' => 'Supervisor Staf No',
            'KodSesi_Sem' => 'Kod Sesi Sem',
        ];
    }
}
