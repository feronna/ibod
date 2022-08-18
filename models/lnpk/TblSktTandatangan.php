<?php

namespace app\models\lnpk;

use Yii;

/**
 * This is the model class for table "hrm.lnpk_tbl_skt_tt".
 *
 * @property int $id
 * @property string $lnpk_id
 * @property string $sign_PYD
 * @property string $sign_dt_PYD
 * @property string $sign_PP
 * @property string $sign_dt_PP
 * @property string $start_date
 * @property string $end_date
 */
class TblSktTandatangan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lnpk_tbl_skt_tt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lnpk_id', 'sign_PYD', 'sign_PP'], 'required'],
            [['lnpk_id'], 'integer'],
            [['sign_dt_PYD', 'sign_dt_PP', 'start_date', 'end_date'], 'safe'],
            [['sign_PYD', 'sign_PP'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lnpk_id' => 'Lnpk ID',
            'sign_PYD' => 'Sign Pyd',
            'sign_dt_PYD' => 'Sign Dt Pyd',
            'sign_PP' => 'Sign Pp',
            'sign_dt_PP' => 'Sign Dt Pp',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
        ];
    }

    public function getBorang()
    {
        return $this->hasOne(TblMain::className(), ['lnpk_id' => 'lnpk_id']);
    }

    public function getTandatanganPyd()
    {
        return '<dl class="row">
            <dt class="col-sm-3">Nama</dt>
            <dd class="col-sm-9">' . $this->borang->pyd->CONm . '</dd>
        
            <dt class="col-sm-3">Tarikh</dt>
            <dd class="col-sm-9">' . $this->sign_dt_PYD . '</dd>
        </dl>';
    }

    public function getTandatanganPpp()
    {
        return '<dl class="row">
            <dt class="col-sm-3">Nama</dt>
            <dd class="col-sm-9">' . $this->borang->ppp->CONm . '</dd>
        
            <dt class="col-sm-3">Tarikh</dt>
            <dd class="col-sm-9">' . $this->sign_dt_PP . '</dd>
        </dl>';
    }
}
