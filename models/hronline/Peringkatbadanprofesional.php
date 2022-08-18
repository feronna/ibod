<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.peringkatbadanprofesional".
 *
 * @property int $id
 * @property string $peringkatNm
 */
class Peringkatbadanprofesional extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.peringkatbadanprofesional';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['peringkatNm'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'peringkatNm' => 'Peringkat Nm',
        ];
    }
}
