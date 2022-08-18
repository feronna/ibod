<?php

namespace app\models\msiso;

use Yii;

/**
 * This is the model class for table "utilities.iso_ref_access".
 *
 * @property int $id
 * @property string $access_type
 */
class RefAccess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.iso_ref_access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['access_type'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'access_type' => 'Access Type',
        ];
    }
}
