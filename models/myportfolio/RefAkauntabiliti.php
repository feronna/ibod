<?php

namespace app\models\myportfolio;

use Yii;

/**
 * This is the model class for table "myportfolio.ref_akauntabiliti".
 *
 * @property int $id
 * @property string $name
 */
class RefAkauntabiliti extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.myjd_ref_akauntabiliti';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 100],
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
