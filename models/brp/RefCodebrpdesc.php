<?php

namespace app\models\brp;

use Yii;

/**
 * This is the model class for table "brp.ref_codebrpdesc".
 *
 * @property int $id
 * @property string $title
 * @property string $code
 */
class RefCodebrpdesc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.brp_ref_codebrpdesc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code'], 'string'],
            [['title'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'code' => 'Code',
        ];
    }
}
