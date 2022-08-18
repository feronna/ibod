<?php

namespace app\models\hronline_gaji;

use Yii;

/**
 * This is the model class for table "hrm.gaji_ref_elaun".
 *
 * @property int $id
 * @property int $elaun_cd
 * @property int $elaun_job_group
 * @property int $elaun_gred_no
 * @property string $elaun_gred_skim
 * @property string $elaun_scheme utk filter perubatan/
 * @property double $elaun_amt
 */
class RefGajiElaun extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.gaji_ref_elaun';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['elaun_cd'], 'required'],
            [['elaun_cd', 'elaun_job_group', 'elaun_gred_no'], 'integer'],
            [['elaun_amt'], 'number'],
            [['elaun_gred_skim'], 'string', 'max' => 5],
            [['elaun_scheme'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'elaun_cd' => 'Elaun Cd',
            'elaun_job_group' => 'Elaun Job Group',
            'elaun_gred_no' => 'Elaun Gred No',
            'elaun_gred_skim' => 'Elaun Gred Skim',
            'elaun_scheme' => 'Elaun Scheme',
            'elaun_amt' => 'Elaun Amt',
        ];
    }

    public function getElaun()
    {
        return $this->hasOne(\app\models\gaji\RefElaunName::className(), ['id' => 'elaun_cd']);
    }
}
