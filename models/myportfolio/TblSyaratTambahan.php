<?php

namespace app\models\myportfolio;

use Yii;

/**
 * This is the model class for table "myportfolio.tbl_syarat_tambahan".
 *
 * @property int $id
 * @property string $syarat_tambahan
 */
class TblSyaratTambahan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.myjd_tbl_syarat_tambahan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['syarat_tambahan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'syarat_tambahan' => 'Syarat Tambahan',
        ];
    }
}
