<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.ref_reason_penempatan".
 *
 * @property int $id
 * @property string $name
 */
class RefReasonPenempatan extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.ref_reason_penempatan';
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
            'reason_id' => 'Reason ID',
            'name' => 'Name',
        ];
    }
}
