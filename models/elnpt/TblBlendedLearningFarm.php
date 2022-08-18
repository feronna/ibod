<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_tbl_blended_learning".
 *
 * @property int $id
 * @property string $username_ic_pasportNo
 * @property string $fullname
 * @property string $status
 * @property string $lastname
 */
class TblBlendedLearningFarm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_tbl_blended_learning';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username_ic_pasportNo', 'fullname', 'lastname'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username_ic_pasportNo' => 'Username Ic Pasport No',
            'fullname' => 'Fullname',
            'status' => 'Status',
            'lastname' => 'Lastname',
        ];
    }
}
