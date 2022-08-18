<?php

namespace app\models\Pengesahan;

use Yii;

/**
 * This is the model class for table "pengesahan.ref_pelanjutan".
 *
 * @property int $id
 * @property string $tempoh
 */
class RefPelanjutan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
//        return 'pengesahan.ref_pelanjutan';
        return 'hrm.sah_ref_pelanjutan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pelanjutan'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pelanjutan' => 'Pelanjutan',
        ];
    }
}
