<?php

namespace app\models\elnpt\simulation;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_ref_calc_fapi".
 *
 * @property int $id
 * @property string $label
 * @property double $k1_k2
 * @property double $k3_k4
 * @property double $k5
 * @property double $k6
 * @property double $limpahan
 * @property int $saiz_kelas
 * @property int $dept_id
 * @property int $isTadbir
 * @property string $gred_skim
 */
class RefCalcFapi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_ref_calc_fapi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['k1_k2', 'k3_k4', 'k5', 'k6', 'limpahan'], 'number'],
            [['saiz_kelas', 'dept_id', 'isTadbir', 'isJawatan'], 'integer'],
            [['label'], 'string', 'max' => 100],
            [['gred_skim'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'label' => 'Label',
            'k1_k2' => 'K1 K2',
            'k3_k4' => 'K3 K4',
            'k5' => 'K5',
            'k6' => 'K6',
            'limpahan' => 'Limpahan',
            'saiz_kelas' => 'Saiz Kelas',
            'dept_id' => 'Dept ID',
            'isTadbir' => 'Is Tadbir',
            'gred_skim' => 'Gred Skim',
        ];
    }
}
