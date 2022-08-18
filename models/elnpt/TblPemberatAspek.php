<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_tbl_pemberat".
 *
 * @property int $id
 * @property int $kump_dept_id
 * @property int $kump_gred_id
 * @property int $aspek_id
 * @property double $pemberat
 */
class TblPemberatAspek extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_tbl_pemberat_aspek';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kump_dept_id', 'kump_gred_id', 'aspek_id'], 'integer'],
            [['pemberat'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kump_dept_id' => 'Kump Dept ID',
            'kump_gred_id' => 'Kump Gred ID',
            'aspek_id' => 'Aspek ID',
            'pemberat' => 'Pemberat',
        ];
    }
}
