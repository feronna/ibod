<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.ref_grade".
 *
 * @property int $id
 * @property string $grade
 * @property int $isActive
 */
class Gred extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.ref_grade';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['isActive'], 'integer'],
            [['grade'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'grade' => 'Grade',
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
