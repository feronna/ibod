<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "hrd.cb_tbl_warta".
 *
 * @property int $id
 * @property string $icno
 * @property string $no_daftar_mmc
 * @property string $no_apc
 */
class TblWarta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_tbl_warta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno'], 'string', 'max' => 12],
            [['no_daftar_mmc', 'no_apc'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'no_daftar_mmc' => 'No Daftar Mmc',
            'no_apc' => 'No Apc',
        ];
    }
}
