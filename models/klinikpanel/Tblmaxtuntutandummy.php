<?php

namespace app\models\klinikpanel;

use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "klinikpanel2.tblmaxtuntutan".
 *
 * @property string $max_icno
 * @property string $max_tuntutan
 * @property string $current_balance
 * @property string $topup_max
 * @property string $tuntutan_bukan_panel
 * @property string $jum_tuntutan
 * @property string $last_update
 * @property string $last_updater
 */
class Tblmaxtuntutandummy extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb()
    {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'klinikpanel2.tblmaxtuntutan_dummy';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['max_icno'], 'required'],
            [['max_tuntutan', 'current_balance', 'topup_max', 'tuntutan_bukan_panel', 'jum_tuntutan'], 'number'],
            [['last_update'], 'safe'],
            [['max_icno'], 'string', 'max' => 12],
            [['last_updater'], 'string', 'max' => 15],
            [['max_icno'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'max_icno' => 'Max Icno',
            'max_tuntutan' => 'Max Tuntutan',
            'current_balance' => 'Current Balance',
            'topup_max' => 'Topup Max',
            'tuntutan_bukan_panel' => 'Tuntutan Bukan Panel',
            'jum_tuntutan' => 'Jum Tuntutan',
            'last_update' => 'Last Update',
            'last_updater' => 'Last Updater',
        ];
    }
    public function getKakitangan()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'max_icno']);
    }

    /**
     * Miji - added 24/08/2020
     * 
     * check klu balance mencukupi utk claim before deduct and after deduct
     * 
     * return boolean.
     */
    public static function checkBalance($icno, $amt)
    {

        $model = self::findOne(['max_icno' => $icno]);

        if ($model) {
            if ($model->current_balance < 100) {
                return false;
            } elseif (($model->current_balance - $amt) < 100) {
                return false;
            } else {
                return true;
            }
        }

        return false;
    }

    /**
     * Miji - added 24/08/2020
     * 
     * function ni utk deduct balance sahaja.. validation semua dlm function checkbalance (diatas)
     * 
     * return boolean.
     */
    public static function deductBalance($icno, $amt)
    {
        $model = self::findOne(['max_icno' => $icno]);

        if ($model) {
            $model->current_balance = $model->current_balance - $amt;
            $model->last_update = date("Y-m-d H:i:s");
            $model->last_updater = 'HUMS-MEDCARE';
            $model->save(false);
            return true;
        }

        return false;
    }

}
