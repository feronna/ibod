<?php

namespace app\models\lnpt;

use Yii;
use app\models\lnpt\markah;

/**
 * This is the model class for table "elnpt.markah".
 *
 * @property int $id
 * @property int $staff_id
 * @property int $tahun
 * @property double $markah
 * @property double $markahPPP
 * @property double $markahPPK
 * @property double $purata
 */
class markah extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'elnpt.markah';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id', 'tahun'], 'required'],
            [['staff_id', 'tahun'], 'integer'],
            [['markah', 'markahPPP', 'markahPPK', 'purata'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_id' => 'Staff ID',
            'tahun' => 'Tahun',
            'markah' => 'Markah',
            'markahPPP' => 'Markah Ppp',
            'markahPPK' => 'Markah Ppk',
            'purata' => 'Purata',
        ];
    }
}
