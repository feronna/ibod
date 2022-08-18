<?php

namespace app\models\hronline;
use app\models\hronline\RTable;
use Yii;

/**
 * This is the model class for table "hronline.updatestatus".
 *
 * @property string $usern
 * @property string $COTableName
 * @property int $COActivity
 * @property string $COUpadteDate
 * @property string $COUpdateIP
 * @property string $COUpdateComp
 * @property string $COUpdateCompUser
 * @property string $COUpdateSQL
 * @property int $id
 * @property string $idval
 */
class Updatestatus extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.updatestatus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usern'], 'required'],
            [['COActivity'], 'integer'],
            [['COUpadteDate'], 'safe'],
            [['COUpdateSQL'], 'string'],
            [['usern', 'COUpdateCompUser'], 'string', 'max' => 20],
            [['COTableName', 'COUpdateIP', 'COUpdateComp'], 'string', 'max' => 50],
            [['idval'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'usern' => 'Usern',
            'COTableName' => 'Co Table Name',
            'COActivity' => 'Co Activity',
            'COUpadteDate' => 'Co Upadte Date',
            'COUpdateIP' => 'Co Update Ip',
            'COUpdateComp' => 'Co Update Comp',
            'COUpdateCompUser' => 'Co Update Comp User',
            'COUpdateSQL' => 'Co Update Sql',
            'id' => 'ID',
            'idval' => 'Idval',
        ];
    }
    
      public function getNamaBahagian() {
        return $this->hasOne(RTable::className(), ['table' => 'COTableName']);
    }
     public function getNamaPengemaskini() {
        return $this->hasOne(\app\models\system_core\Tblprcobiodata::className(), ['ICNO' => 'COUpdateCompUser']);
    }
    
    public function getTarikhKemaskini() {
        return  Yii::$app->MP->Tarikh($this->COUpadteDate);
    }
}
