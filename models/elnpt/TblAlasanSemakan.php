<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_tbl_alasan_semakan".
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
        return 'hrm.elnpt_tbl_alasan_semakan';
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
