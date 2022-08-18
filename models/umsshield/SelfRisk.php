<?php

namespace app\models\umsshield;

use Yii;
use aryelds\sweetalert\SweetAlert;
use DateTime;

/**
 * This is the model class for table "dbo.SelfRiskAssessmentResultStaff".
 *
 * @property string $icno
 * @property int $riskGroupId
 * @property string $assessmentTaken
 */
class SelfRisk extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.SelfRiskAssessmentResultStaff';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db12');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['riskGroupId'], 'integer'],
            [['icno'], 'string', 'max' => 50],
            [['assessmentTaken'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'icno' => 'Icno',
            'riskGroupId' => 'Risk Group ID',
            'assessmentTaken' => 'Assessment Taken',
        ];
    }

    public static function status($icno)
    {
        //$model = SelfRisk::find()->where(['icno' => $icno])->andWhere('assessmentTaken >= Convert(datetime, \'2020-10-11\')')->one();
        //return $model ? $model->riskGroupId : '';
        return 1;
    }

    public static function viewstatus($icno)
    {
        $model = SelfRisk::status($icno);
        if ($model) {
            if ($model == 2 || $model == 3) {
                return
                    [
                        'title' => "UMS Shields Info",
                        'text' => '<span class="label label-danger">RED</span><br><br>'
                            . 'Anda diminta bekerja dari rumah (wfh)',
                        'html' => true,
                        'type' => SweetAlert::TYPE_WARNING,
                        'confirmButtonText' => "OK",
                        'closeOnConfirm' => false
                    ];
            } elseif ($model == 4) {
                return
                    [
                        'title' => "UMS Shields Info",
                        'text' => '<span class="label" style="background-color: yellow;">YELLOW</span><br><br>'
                            . 'Anda diminta bekerja dari rumah (wfh)',
                        'html' => true,
                        'type' => SweetAlert::TYPE_WARNING,
                        'confirmButtonText' => "OK",
                        'closeOnConfirm' => false
                    ];
            } elseif ($model == 6) {
                return
                    [
                        'title' => "UMS Shields Info",
                        'text' => '<span class="label label-success">GREEN</span><br><br>'
                            . 'Anda dibenarkan untuk hadir bertugas ke pejabat seperti biasa',
                        'html' => true,
                        'type' => SweetAlert::TYPE_SUCCESS,
                        'confirmButtonText' => "OK",
                        'closeOnConfirm' => false
                    ];
            }
        } else {
            return
                [
                    'title' => "UMS Shields Info",
                    'text' => 'Anda dikehendaki untuk mengisi semula borang penilaian risiko individu untuk jangkitan COVID-19 '
                        . '(UMS Shields COVID-19 Self-Assessment Tool).<br><br> Sila lengkapkan di pautan'
                        . ' <a href="https://shields.ums.edu.my/">https://shields.ums.edu.my/</a>',
                    'html' => true,
                    'type' => SweetAlert::TYPE_ERROR,
                    'showConfirmButton' => false,
                    'allowEscapeKey' => false,
                ];
        }
    }

    public static function typestatus($icno)
    {
        $model = 6;
        if ($model) {
            if ($model == 2 || $model == 3) {
                return SweetAlert::TYPE_WARNING;
            } elseif ($model == 4) {
                return SweetAlert::TYPE_WARNING;
            } elseif ($model == 6) {
                return SweetAlert::TYPE_SUCCESS;
            }
        } else {
            return SweetAlert::TYPE_ERROR;
        }
    }

    public static function shieldStatus($icno)
    {
        $model = self::status($icno);
        if ($model) {
            if ($model == 2 || $model == 3) {
                return 'RED';
            } elseif ($model == 4) {
                return 'YELLOW';
            } elseif ($model == 6) {
                return 'GREEN';
            }
        } else {
            return 'BELUM ISI SHIELD';
        }
    }

    public static function shieldRecord($icno)
    {
        $model = self::findOne(['icno' => $icno]);
        return $model;
    }

    public function getColor()
    {
        if ($this->riskGroupId == 2) {
            return 'RED';
        }
        if ($this->riskGroupId == 3) {
            return 'RED';
        }
        if ($this->riskGroupId == 4) {
            return 'YELLOW';
        }
        if ($this->riskGroupId == 6) {
            return 'GREEN';
        }
    }

    public function getTarikh()
    {
        // $date = date_create();

        $myDateTime = DateTime::createFromFormat('m-d-Y H:i:sA', $this->assessmentTaken);
        return $myDateTime->format('d/m/Y H:i A');

    }

    public function getEndTarikh()
    {
        $myDateTime = DateTime::createFromFormat('m-d-Y H:i:sA', $this->assessmentTaken);
        $myDateTime->modify('+1 week');
        return $myDateTime->format('d/m/Y');
    }
}
