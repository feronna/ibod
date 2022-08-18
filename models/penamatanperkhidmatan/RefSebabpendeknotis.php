<?php

namespace app\models\penamatanperkhidmatan;

use Yii;

/**
 * This is the model class for table "penamatanperkhidmatan.ref_sebabpendeknotis".
 *
 * @property int $id
 * @property string $sebab
 */
class RefSebabpendeknotis extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.tamat_ref_sebabpendeknotis';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sebab'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sebab' => 'Sebab',
        ];
    }
}
