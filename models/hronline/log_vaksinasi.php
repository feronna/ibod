<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.log_vaksinasi".
 *
 * @property int $id
 * @property string $usern
 * @property string $TableName
 * @property int $Activity
 * @property string $UpdateDate
 * @property string $UpdateIP
 * @property string $UpdateComp
 * @property string $UpdateCompUser
 * @property string $UpdateSQL
 * @property string $idval
 */
class log_vaksinasi extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }

    public static function tableName()
    {
        return 'hronline.log_vaksinasi';
    }

    public function rules()
    {
        return [
            [['Activity'], 'integer'],
            [['UpdateDate'], 'safe'],
            [['UpdateSQL'], 'string'],
            [['usern'], 'string', 'max' => 15],
            [['TableName', 'UpdateIP', 'UpdateComp', 'UpdateCompUser'], 'string', 'max' => 50],
            [['idval'], 'string', 'max' => 20],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usern' => 'Usern',
            'TableName' => 'Table Name',
            'Activity' => 'Activity',
            'UpdateDate' => 'Update Date',
            'UpdateIP' => 'Update Ip',
            'UpdateComp' => 'Update Comp',
            'UpdateCompUser' => 'Update Comp User',
            'UpdateSQL' => 'Update Sql',
            'idval' => 'Idval',
        ];
    }
}
