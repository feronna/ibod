<?php

namespace app\models\ejobs;

use Yii;

/**
 * This is the model class for table "ejobs.iklan_taraf_jawatan".
 *
 * @property int $id
 * @property int $iklan_id
 * @property int $taraf_jawatan_id
 */
class TarafJawatan extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7');  // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ejobs.iklan_taraf_jawatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iklan_id', 'taraf_jawatan_id'], 'required'],
            [['iklan_id', 'taraf_jawatan_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'iklan_id' => 'Iklan ID',
            'taraf_jawatan_id' => 'Taraf Jawatan',
        ];
    }
     
     public function getTaraf() {
        return $this->hasOne(\app\models\hronline\StatusLantikan::className(), ['ApmtStatusCd' => 'taraf_jawatan_id']);
    }
}
