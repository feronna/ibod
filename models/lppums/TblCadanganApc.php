<?php

namespace app\models\lppums;

use Yii;

/**
 * This is the model class for table "hrm.lppums_cadangan_apc".
 *
 * @property string $cadangan_apc_id
 * @property string $lpp_id
 * @property string $catatan
 * @property int $cadang 1=cadang, 2 = panel penerima apc, 3 = apt
 * @property int $panel
 */
class TblCadanganApc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_cadangan_apc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_id', 'cadang', 'panel'], 'integer'],
            [['catatan'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cadangan_apc_id' => 'Cadangan Apc ID',
            'lpp_id' => 'Lpp ID',
            'catatan' => 'Catatan',
            'cadang' => 'Cadang',
            'panel' => 'Panel',
        ];
    }
}
