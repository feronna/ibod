<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.tbl_bantuan".
 *
 * @property int $id
 * @property string $jenisBantuan
 * @property int $BantuanCd
 */
class TblBantuan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_tbl_bantuan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['BantuanCd'], 'integer'],
            [['bentukBantuan'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bentukBantuan' => 'Jenis Bantuan',
            'BantuanCd' => 'Bantuan Cd',
        ];
    }
}
