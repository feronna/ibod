<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.ref_subject".
 *
 * @property int $id
 * @property string $EduSubjek
 * @property int $EduLevel_id
 * @property int $isActive
 */
class Subjek extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.ref_subject';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['EduLevel_id', 'isActive'], 'integer'],
            [['EduSubjek'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'EduSubjek' => 'Edu Subjek',
            'EduLevel_id' => 'Edu Level ID',
            'isActive' => 'Is Active',
        ];
    }
    
    public function getStatus() {
        if($this->isActive){
            return 'Aktif';
        }
        return 'Tidak aktif';
    }

}
