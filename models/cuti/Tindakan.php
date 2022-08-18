<?php

namespace app\models\cuti;

use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "e_cuti.tindakan".
 *
 * @property int $id
 * @property string $icno_pemberi_kuasa icno pemberi kuasa - melulus sahaja (utk ketua jabatan, VC, Dekan, TNC)
 * @property string $icno_tindakan icno staf yang melaksana - Setiausaha pejabat
 * @property string $catatan
 * @property string $status 1 = aktif || 0 x aktif
 * @property string $create_datetime
 * @property string $update_datetime
 */
class Tindakan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cuti_behalf_action';
        // return 'e_cuti.tindakan';
    }
    public $temp;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno_pemberi_kuasa', 'icno_tindakan'], 'required'],
            [['catatan', 'status'], 'string'],
            [['create_datetime', 'update_datetime', 'temp'], 'safe'],
            [['icno_pemberi_kuasa', 'icno_tindakan'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno_pemberi_kuasa' => 'Icno Pemberi Kuasa',
            'icno_tindakan' => 'Icno Tindakan',
            'catatan' => 'Catatan',
            'status' => 'Status',
            'create_datetime' => 'Create Datetime',
            'update_datetime' => 'Update Datetime',
        ];
    }
    public function getOfficer()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno_pemberi_kuasa']);
    }
    public function getExecutive()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno_tindakan']);
    }

    public static function behalf($icno){
        $action = self::find()->where(['icno_tindakan'=>$icno])->one();

        if($action){
            $icno = $action->icno_pemberi_kuasa;
        }else{
            $icno = $icno;
        }
        return $icno;
    }

    public static function penerimaTindakan($icno)
    {
        $tindakan = self::find()->where(['icno_tindakan' => $icno])->one();

        if ($tindakan) {
            $icno2 = $tindakan->icno_pemberi_kuasa;
        } else {
            $icno2 = $icno;
        }

        return $icno2;
    }
}
