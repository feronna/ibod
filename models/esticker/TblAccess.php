<?php

namespace app\models\esticker;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "keselamatan.stc_tbl_access".
 *
 * @property int $id
 * @property string $ICNO
 * @property int $access
 */
class TblAccess extends \yii\db\ActiveRecord
{
    public $lvl = [];
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.stc_tbl_access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['access','ICNO'], 'required'],
            [['lvl'], 'safe'],
            [['access','lvl'], 'integer'],
            [['ICNO'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ICNO' => 'NAMA',
            'access' => 'LEVEL',
        ];
    }
    
    public function getBiodata() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }
    
    public function getLevel() {
        return $this->hasOne(RefAccess::className(), ['id' => 'access']);
    }
    
    public function findRekodLevel() {
        return ArrayHelper::toArray(TblAccess::find()->select('access')->where(['ICNO' => $this->ICNO])->column());
    }
}
