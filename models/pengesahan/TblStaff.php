<?php

namespace app\models\pengesahan;

use Yii;

/**
 * This is the model class for table "hrm.sah_tbl_staff".
 *
 * @property int $id
 * @property string $icno
 * @property int $category
 */
class TblStaff extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.sah_tbl_staff';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category'], 'integer'],
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
            'category' => 'Category',
        ];
    }
}
