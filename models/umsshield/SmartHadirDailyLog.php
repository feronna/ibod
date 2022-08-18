<?php

namespace app\models\umsshield;

use app\models\w_letter\TempIcno;
use Yii;
use aryelds\sweetalert\SweetAlert;
use app\models\kehadiran\TblWfh;

/**
 * This is the model class for table "dbo.SmartHadirUnionShieldsLogStaff".
 *
 * @property string $icno
 * @property string $Location
 * @property string $timestamp
 */
class SmartHadirDailyLog extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.SmartHadirUnionShieldsLogStaff';
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
            [['timestamp'], 'safe'],
            [['icno'], 'string', 'max' => 50],
            [['Location'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'icno' => 'Icno',
            'Location' => 'Location',
            'timestamp' => 'Timestamp',
        ];
    }

    public static function checkQr($icno)
    {
        $tester = [
            890426495037,
            921126126634,
            820202125615,
            840813125655,
            901021125258,
            950418125652,
            950426125329,
            940402125181,
            950517126538,
            731011135058,
            840926125686,
            801004125610,
            930807125121,
            950510125946,
            950829125446,
            950117126440,
            940522155035,
            840801125017,
            810209105562,
            870427125355,
            850922125055,
            870515355599,
            911214125042,
            881125495442,
            810530125228,
            920316136142,
            840325125568,
        ];

        if (in_array($icno, $tester)) {

            $model = self::findOne(['icno' => $icno]);

            $dateNow = date('Y-m-d');

            $isWfh = TblWfh::isWfh($dateNow, $icno);

            if ($isWfh == 0) {

                if ($model) {
                    return
                        [
                            'title' => "Smart-Hadir Info",
                            'text' => '<span class="label label-success">' . $model->Location . '</span><br><br>'
                                . 'Anda telah mengimbas QRCode SmartHadir.',
                            'html' => true,
                            'type' => SweetAlert::TYPE_SUCCESS,
                            'confirmButtonText' => "OK",
                            'closeOnConfirm' => false
                        ];
                } else {
                    return
                        [
                            'title' => "Smart-Hadir Info",
                            'text' => 'Anda diwajibkan untuk mengimbas QRCode Smart-Hadir dimana-mana kawasan di dalam UMS',
                            'html' => true,
                            'type' => SweetAlert::TYPE_ERROR,
                            'showConfirmButton' => false,
                        ];
                }
            } else {
                return false;
            }
        }
    }
}
