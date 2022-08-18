<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.positionstatus".
 *
 * @property string $StatusCd
 * @property string $PosStatus
 * @property int $isActive
 */
class StatusJawatan extends \yii\db\ActiveRecord
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
        return 'hronline.positionstatus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['isActive'], 'integer'],
            [['StatusCd'], 'string', 'max' => 1],
            [['PosStatus'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'StatusCd' => 'Status Cd',
            'PosStatus' => 'Pos Status',
            'isActive' => 'Is Active',
        ];
    }
}
