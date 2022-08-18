<?php

namespace app\models\lppums\v2;

use Yii;
use app\models\lppums\TblMain;

/**
 * This is the model class for table "hrm.lppums_v2_tbl_skt".
 *
 * @property int $id
 * @property string $lpp_id
 * @property int $aspek_id
 * @property int $month
 * @property string $ringkasan
 * @property string $sasaran_kerja
 * @property string $capai
 * @property string $catatan
 * @property string $created_dt
 * @property string $updated_dt
 * @property string $deleted_dt
 */
class TblSktv2 extends \yii\db\ActiveRecord
{
    const SCENARIO_AKTIVITI = 'aktiviti';
    const SCENARIO_SKT = 'skt';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_v2_tbl_skt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ringkasan', 'sasaran_kerja', 'capai', 'aspek_id', 'month', 'lpp_id', 'created_dt'], 'required', 'on' => self::SCENARIO_SKT],
            [['ringkasan', 'sasaran_kerja', 'aspek_id', 'month', 'lpp_id', 'created_dt'], 'required', 'on' => self::SCENARIO_AKTIVITI],
            [['lpp_id', 'aspek_id', 'month'], 'integer'],
            [['catatan'], 'string'],
            [['created_dt', 'updated_dt', 'deleted_dt'], 'safe'],
            [['ringkasan', 'sasaran_kerja', 'capai'], 'string', 'max' => 300],
            // [['month'], 'validateMonth'],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[static::SCENARIO_SKT] = ['ringkasan', 'sasaran_kerja', 'capai', 'aspek_id', 'month'];
        $scenarios[static::SCENARIO_AKTIVITI] = ['ringkasan', 'sasaran_kerja',  'aspek_id', 'month'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lpp_id' => 'Lpp ID',
            'aspek_id' => 'Aspek',
            'month' => 'Bulan',
            'ringkasan' => ($this->scenario == 'aktiviti' ? 'Peranan' : 'Ringkasan'),
            'sasaran_kerja' => ($this->scenario == 'aktiviti' ? 'Ringkasan Aktiviti' : 'Sasaran Kerja'),
            'capai' => 'Pencapaian',
            'catatan' => 'Catatan',
            'created_dt' => 'Created Dt',
            'updated_dt' => 'Updated Dt',
            'deleted_dt' => 'Deleted Dt',
        ];
    }

    public function getMonthLabel()
    {
        return $this->hasOne(RefMonths::className(), ['month' => 'month']);
    }

    public function getDocument()
    {
        return $this->hasOne(TblDocuments::className(), ['id_skt' => 'id']);
    }

    public function getBorang()
    {
        return $this->hasOne(TblMain::className(), ['lpp_id' => 'lpp_id']);
    }

    public function getAspek()
    {
        return $this->hasOne(RefAspek::className(), ['id' => 'aspek_id']);
    }

    public function validateMonth($attribute, $params, $validator)
    {
        if ($this->month != date('m') && ($this->month != date('m') - 1)) {
            $this->addError($attribute, 'Month is not the current or previous month');
        }

        $this->addErrors($this->getErrors($attribute));
    }
}
