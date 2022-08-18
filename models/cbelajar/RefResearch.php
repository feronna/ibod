<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.ref_research".
 *
 * @property int $id
 * @property string $stage
 */
class RefResearch extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_ref_research';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['stage'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'stage' => 'Stage',
        ];
    }
}
