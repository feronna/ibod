<?php

namespace app\models\Kontrak;

use Yii;

/**
 * This is the model class for table "kontrak.ref_tempoh".
 *
 * @property int $id
 * @property string $tempoh
 */
class RefTempoh extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.kontrak_ref_tempoh';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tempoh'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tempoh' => 'Tempoh',
        ];
    }
}
