<?php

namespace app\models\esticker;

use Yii;

/**
 * This is the model class for table "keselamatan.stc_ref_access".
 *
 * @property int $id
 * @property string $desc
 */
class RefAccess extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.stc_ref_access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['desc'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'desc' => 'Desc',
        ];
    }
}
