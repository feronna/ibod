<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_ref_kump_dept".
 *
 * @property int $id
 * @property string $kump_dept
 */
class RefKumpDept extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_ref_kump_dept';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kump_dept'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kump_dept' => 'Kump Dept',
        ];
    }
}
