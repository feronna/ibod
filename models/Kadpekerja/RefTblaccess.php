<?php

namespace app\models\Kadpekerja;

use Yii;

/**
 * This is the model class for table "facility_keselamatan.utils_ref_tbl_access".
 *
 * @property int $id
 * @property string $access_type
 */
class RefTblaccess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.utils_ref_tbl_access';
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
