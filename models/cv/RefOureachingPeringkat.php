<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "cvonline.ref_oureaching_peringkat".
 *
 * @property int $id
 * @property string $peringkat
 */
class RefOureachingPeringkat extends \yii\db\ActiveRecord
{
    public static function getDb()
    {
        return Yii::$app->get('db');
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cv_ref_oureaching_peringkat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['peringkat'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'peringkat' => 'Peringkat',
        ];
    }
}
