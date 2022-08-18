<?php

namespace app\models\pinjaman;

use Yii;

/**
 * This is the model class for table "pinjaman.ref_bank".
 *
 * @property int $id
 * @property string $agensi_bank
 * @property int $isActive
 */
class Refbank extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.fac_ref_agensi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['isActive'], 'integer'],
            [['agensi_bank'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'agensi_bank' => 'Agensi Bank',
            'isActive' => 'Is Active',
        ];
    }
}
