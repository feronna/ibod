<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.log_activity".
 *
 * @property int $id
 * @property string $usern
 * @property string $COTableName
 * @property int $COActivity
 * @property string $COUpadteDate
 * @property string $COUpdateIP
 * @property string $COUpdateComp
 * @property string $COUpdateCompUser
 * @property string $COUpdateSQL
 * @property string $idval
 */
class LogActivity extends \yii\db\ActiveRecord
{

    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    public static function tableName()
    {
        return 'hronline.log_activity';
    }

    public function rules()
    {
        return [
            [['COActivity'], 'integer'],
            [['COUpadteDate'], 'safe'],
            [['COUpdateSQL'], 'string'],
            [['usern', 'COUpdateCompUser'], 'string', 'max' => 20],
            [['COTableName', 'COUpdateIP', 'COUpdateComp'], 'string', 'max' => 50],
            [['idval'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usern' => 'Usern',
            'COTableName' => 'Co Table Name',
            'COActivity' => 'Co Activity',
            'COUpadteDate' => 'Co Upadte Date',
            'COUpdateIP' => 'Co Update Ip',
            'COUpdateComp' => 'Co Update Comp',
            'COUpdateCompUser' => 'Co Update Comp User',
            'COUpdateSQL' => 'Co Update Sql',
            'idval' => 'Idval',
        ];
    }
}
