<?php

namespace app\models\ptm;

use app\models\hronline\Tblprcobiodata;

use Yii;

/**
 * This is the model class for table "hrd.ptm_tbl_siri_ptm".
 *
 * @property int $siri_id
 * @property string $start_dt
 * @property string $end_dt
 * @property string $tempat
 * @property int $bil_mesy
 * @property string $mesy_dt
 * @property string $entry_dt
 * @property string $entry_by
 */
class TblPtm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.ptm_tbl_siri_ptm';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start_dt', 'end_dt'], 'required'],
            [['start_dt', 'end_dt', 'mesy_dt', 'entry_dt', 'full_dt', 'siri'], 'safe'],
            [['bil_mesy'], 'integer'],
            [['tempat'], 'string', 'max' => 200],
            [['entry_by'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'siri_id' => 'Siri ID',
            'full_dt' => 'Tarikh Kursus PTM',
            'start_dt' => 'Start Dt',
            'end_dt' => 'End Dt',
            'tempat' => 'Tempat',
            'bil_mesy' => 'Bil Mesy',
            'mesy_dt' => 'Mesy Dt',
            'entry_dt' => 'Direkodkan Pada',
            'entry_by' => 'Direkodkan Oleh',
        ];
    }

    public function getTotalDays()
    {
        $date1 = \date_create(\date('Y-m-d', strtotime(str_replace("/", "-", $this->start_dt))));
        $date2 = \date_create(\date('Y-m-d', strtotime(str_replace("/", "-", $this->end_dt))));
        $diff = \date_diff($date1, $date2);
        return $diff->format("%a") + 1;
    }

    public function getEntry()
    {      
            return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'entry_by']);
    }
}
