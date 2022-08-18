<?php

namespace app\models\umsshield;

use aryelds\sweetalert\SweetAlert;
use Yii;

/**
 * This is the model class for table "dbo.PreVacAssessmentStaffIncomplete".
 *
 * @property string $icno
 * @property string $isCompleted
 */
class PreVacAssessment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.PreVacAssessmentStaffIncomplete';
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
            [['icno'], 'string', 'max' => 50],
            [['isCompleted'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'icno' => 'Icno',
            'isCompleted' => 'Is Completed',
        ];
    }

    public static function viewstatus($icno)
    {
        $model = self::find()->where(['icno' => $icno, 'isCompleted' => 'INCOMPLETE'])->one();
        if ($model) {
        return
            [
                'title' => 'Pre-Vaccination Info',
                'text' => '<font style="color:red;"><strong>Anda dikehendaki </strong></font> untuk mengisi <font style="color:red;"><b>borang penilaian Pra-Vaksinasi COVID-19</b></font>'
                    . '<br>(UMS SHIELDS COVID-19 Pre-Vaccination Tool).<br><br> Sila lengkapkan di pautan'
                    . ' <a href="https://shields.ums.edu.my/web/index.php?r=pre-vac-assessment%2Fpre-vac-health-home">https://shields.ums.edu.my/web/index.php?r=pre-vac-assessment%2Fpre-vac-health-home</a>',
                'html' => true,
                'type' => SweetAlert::TYPE_ERROR,
                'showConfirmButton' => false,
                'allowEscapeKey' => false,
            ];
        }

        return false;
    }

    public static function tester($icno)
    {
        return [
            '830409125689',
            '890426495037',
            '840813125655',
            '840801125017',
        ];
    }

    public static function status($icno)
    {
        $model = PreVacAssessment::find()->where(['icno' => $icno])->one();

        if ($model) {
            return 1;
        }

        return 0;
    }
}
