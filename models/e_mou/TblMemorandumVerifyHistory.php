<?php

namespace app\models\e_mou;

use Yii;

/**
 * This is the model class for table "emou.t_emou16_verifyhistory".
 *
 * @property int $verifyhistory_id ID
 * @property int $id_memorandum Memorandum
 * @property int $id_verify Semakan Canselori
 * @property string $verify_date Tarikh Semakan
 * @property string $verify_comment Komen
 */
class TblMemorandumVerifyHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emou.t_emou16_verifyhistory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_memorandum', 'id_verify'], 'required'],
            [['id_memorandum', 'id_verify'], 'integer'],
            [['verify_date'], 'safe'],
            [['verify_comment'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'verifyhistory_id' => 'Verifyhistory ID',
            'id_memorandum' => 'Id Memorandum',
            'id_verify' => 'Id Verify',
            'verify_date' => 'Verify Date',
            'verify_comment' => 'Verify Comment',
        ];
    }

    public function getVerify()
    {
        return $this->hasOne(RefVerifyHIstory::className(), ['verify_id' => 'id_verify']);
    }
}
