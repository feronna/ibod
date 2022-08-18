<?php

namespace app\models\ejobs;

use Yii;

/**
 * This is the model class for table "ejobs.iklan_penempatan".
 *
 * @property int $id
 * @property int $iklan_id
 * @property int $penempatan_id
 */
class Penempatan extends \yii\db\ActiveRecord
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
        return 'ejobs.iklan_penempatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iklan_id', 'penempatan_id'], 'integer'],
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
            'penempatan_id' => 'Penempatan ID',
        ];
    }
    
    public function getCampus(){
        return $this->hasOne(\app\models\hronline\Kampus::className(), ['campus_id' => 'penempatan_id']);  
    }
}
