<?php

namespace app\models\myidp;

use Yii;
use app\models\myidp\PermohonanKursusLuar;

/**
 * This is the model class for table "hrd.idp_tbl_suratkursusluar".
 *
 * @property int $permohonanID
 * @property string $date_created
 * @property int $status_ul 0 => BELUM DISEMAK, 1 => TELAH DISEMAK
 * @property int $status_pl 0 => BELUM DISEMAK, 1 => TELAH DISEMAK
 * @property string $date_ul
 * @property string $date_pl
 */
class  SuratKursusLuar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.idp_tbl_suratkursusluar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['permohonanID'], 'required'],
            [['permohonanID', 'status_ul', 'status_pl'], 'integer'],
            [['date_created', 'date_ul', 'date_pl'], 'safe'],
            [['user_ul', 'user_pl'], 'string', 'max' => 12],
            [['permohonanID'], 'unique'],
            [['justifikasi_ul'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'permohonanID' => 'Permohonan ID',
            'date_created' => 'Date Created',
            'status_ul' => 'Status Ul',
            'status_pl' => 'Status Pl',
            'date_ul' => 'Date Ul',
            'date_pl' => 'Date Pl',
            'user_ul' => 'User Ul',
            'user_pl' => 'User Pl',
            'justifikasi_ul' => 'Justifikasi',
        ];
    }
    
    /** Relation **/
    public function getPermohonanLulus(){
        return $this->hasOne(PermohonanKursusLuar::className(), ['permohonanID'=>'permohonanID']);
    }
}
