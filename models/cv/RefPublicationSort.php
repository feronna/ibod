<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "hrm.cv_ref_publication_sort".
 *
 * @property int $id
 * @property string $name
 */
class RefPublicationSort extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cv_ref_publication_sort';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
}
