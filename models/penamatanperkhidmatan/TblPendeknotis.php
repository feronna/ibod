<?php

namespace app\models\penamatanperkhidmatan;

use Yii;

/**
 * This is the model class for table "penamatanperkhidmatan.tbl_pendeknotis".
 *
 * @property int $id
 * @property int $permohonan_id
 * @property int $sebabpendeknotis_id
 * @property string $sebab_lain
 */
class TblPendeknotis extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.tamat_tbl_pendeknotis';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['permohonan_id', 'sebabpendeknotis_id'], 'integer'],
            [['sebab_lain'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'permohonan_id' => 'Permohonan ID',
            'sebabpendeknotis_id' => 'Sebabpendeknotis ID',
            'sebab_lain' => 'Sebab Lain',
        ];
    }
}
