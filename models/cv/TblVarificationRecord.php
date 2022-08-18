<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "{{%hrm.cv_tbl_log_verified}}".
 *
 * @property int $id
 * @property string $ICNO
 * @property string $verification_type
 * @property int $ref_id
 * @property int $verified
 * @property string $created_by
 * @property string $created_at
 * @property string $remark
 * @property string $serialize
 */
class TblVarificationRecord extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrm.cv_tbl_log_verified}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ref_id', 'verified','type_id'], 'integer'],
            [['created_at'], 'safe'],
            [['ICNO', 'created_by'], 'string', 'max' => 12], 
            [['remark'], 'string', 'max' => 500],
            [['serialize'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'verification_type' => 'Verification Type',
            'ref_id' => 'Ref ID',
            'verified' => 'Verified',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'remark' => 'Remark',
            'serialize' => 'Serialize',
        ];
    }
}
