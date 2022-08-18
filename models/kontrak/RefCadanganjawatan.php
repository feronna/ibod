<?php

namespace app\models\kontrak;

use Yii;

/**
 * This is the model class for table "kontrak.ref_cadanganjawatan".
 *
 * @property int $id
 * @property string $jawatan
 */
class RefCadanganjawatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.kontrak_ref_cadanganjawatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jawatan'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jawatan' => 'Jawatan',
        ];
    }
}
