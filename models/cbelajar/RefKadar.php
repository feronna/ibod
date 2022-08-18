<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "hrd.cb_ref_kadar".
 *
 * @property int $id
 * @property string $kadar
 * @property string $perkara
 */
class RefKadar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_ref_kadar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['perkara'], 'string'],
            [['kadar'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kadar' => 'Kadar',
            'perkara' => 'Perkara',
        ];
    }
}
