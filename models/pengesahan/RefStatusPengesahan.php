<?php

namespace app\models\pengesahan;

use Yii;

/**
 * This is the model class for table "pengesahan.ref_status_pengesahan".
 *
 * @property int $ConfirmStatusCd
 * @property string $ConfirmStatusNm
 */
class RefStatusPengesahan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
//        return 'pengesahan.ref_status_pengesahan';
        return 'hrm.sah_ref_status_pengesahan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ConfirmStatusCd'], 'required'],
            [['ConfirmStatusCd'], 'integer'],
            [['ConfirmStatusNm'], 'string', 'max' => 255],
            [['ConfirmStatusCd'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ConfirmStatusCd' => 'Confirm Status Cd',
            'ConfirmStatusNm' => 'Confirm Status Nm',
        ];
    }
}
