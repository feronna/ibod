<?php

namespace app\models\ejobs;

use Yii;

/**
 * This is the model class for table "ejobs.iklan_tugas_jawatan".
 *
 * @property int $id
 * @property int $iklan_id
 * @property string $tugas_desc
 */
class TugasJawatan extends \yii\db\ActiveRecord
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
        return 'ejobs.iklan_tugas_jawatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jawatan_id', 'tugas_desc'], 'required', 'message'=>'Ruang ini adalah mandatori'],
            [['jawatan_id'], 'integer'],
            [['tugas_desc'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jawatan_id' => 'Iklan ID',
            'tugas_desc' => 'Keterangan Tugas:',
        ];
    }
}
