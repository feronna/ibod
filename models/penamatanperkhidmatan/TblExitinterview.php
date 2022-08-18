<?php

namespace app\models\penamatanperkhidmatan;

use Yii;

/**
 * This is the model class for table "penamatanperkhidmatan.tbl_exitinterview".
 *
 * @property int $id
 * @property string $icno
 * @property int $soalan_id
 * @property string $jawapan
 */
class TblExitinterview extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.tamat_tbl_exitinterview';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['soalan_id'], 'integer'],
            [['jawapan'], 'string'],
            [['icno'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'soalan_id' => 'Soalan ID',
            'jawapan' => 'Jawapan',
        ];
    }
}
