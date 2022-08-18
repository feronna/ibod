<?php

namespace app\models\lppums;

use Yii;

/**
 * This is the model class for table "hrm.lppums_tbl_alasan_semakan".
 *
 * @property int $id
 * @property string $lpp_id
 * @property int $id_alasan
 * @property string $alasan
 */
class TblAlasanSemakan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_tbl_alasan_semakan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_id', 'id_alasan'], 'integer'],
            [['alasan'], 'string', 'max' => 800],
            [['alasan'], 'required',]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lpp_id' => 'Lpp ID',
            'id_alasan' => 'Id Alasan',
            'alasan' => 'Alasan',
        ];
    }
}
