<?php

namespace app\models\Pengesahan;

use Yii;

/**
 * This is the model class for table "pengesahan.ref_tempoh".
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
//        return 'pengesahan.ref_tempoh';
        return 'hrm.sah_ref_tempoh';
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
