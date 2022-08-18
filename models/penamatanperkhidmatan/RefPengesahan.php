<?php

namespace app\models\penamatanperkhidmatan;

use Yii;

/**
 * This is the model class for table "penamatanperkhidmatan.ref_pengesahan".
 *
 * @property int $id
 * @property int $jfpiu
 * @property string $perkara
 */
class RefPengesahan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.tamat_ref_pengesahan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jfpiu'], 'integer'],
            [['perkara'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jfpiu' => 'Jfpiu',
            'perkara' => 'Perkara',
        ];
    }
}
