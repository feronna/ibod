<?php

namespace app\models\ejobs;

use Yii;

/**
 * This is the model class for table "ejobs.tbl_sbbfail".
 *
 * @property int $id
 * @property int $permohonan_id
 * @property string $desc
 */
class TblpSbbSaringanFail extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ejobs.tbl_sbbsaringanfail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['permohonan_id'], 'integer'],
            [['desc'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'permohonan_id' => 'Permohonan ID',
            'desc' => 'Desc',
        ];
    }
}
