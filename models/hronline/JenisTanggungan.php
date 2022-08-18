<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.dependency".
 *
 * @property string $DependencyCd
 * @property string $DependencyNm
 */
class JenisTanggungan extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.dependency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['DependencyCd'], 'required'],
            [['DependencyCd'], 'string', 'max' => 3],
            [['DependencyNm'], 'string', 'max' => 255],
            [['DependencyCd'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'DependencyCd' => 'Dependency Cd',
            'DependencyNm' => 'Dependency Nm',
        ];
    }
}
