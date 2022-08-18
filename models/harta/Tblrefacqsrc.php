<?php

namespace app\models\harta;

use Yii;

/**
 * This is the model class for table "harta.tblrefacqsrc".
 *
 * @property int $id
 * @property string $AcqSrcCd
 * @property string $AcqSrcNm
 */
class Tblrefacqsrc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.harta_tblrefacqsrc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['AcqSrcCd'], 'required'],
            [['AcqSrcCd'], 'string', 'max' => 2],
            [['AcqSrcNm'], 'string', 'max' => 80],
            [['AcqSrcCd'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'AcqSrcCd' => 'Acq Src Cd',
            'AcqSrcNm' => 'Acq Src Nm',
        ];
    }
}
