<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "cvonline.ptk_output".
 *
 * @property int $id
 * @property string $aras
 */
class RefPtkOutput extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cvonline.ptk_output';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['aras'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'aras' => 'Aras',
        ];
    }
}
