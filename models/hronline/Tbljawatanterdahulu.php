<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.tblprprevpost".
 *
 * @property string $ICNO
 * @property string $PrevPostNm
 * @property string $PrevPostStartDt
 * @property string $PrevPostEndDt
 * @property string $PrevPostDesc
 * @property int $id
 */
class Tbljawatanterdahulu extends \yii\db\ActiveRecord
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
        return 'hronline.tblprprevpost';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'PrevPostNm','PrevPostDesc'], 'required', 'message'=>'Ruang ini adalah mandatori'],
            [['PrevPostStartDt', 'PrevPostEndDt'], 'safe'],
            [['ICNO'], 'string', 'max' => 12],
            [['PrevPostNm'], 'string', 'max' => 80],
            [['PrevPostDesc'], 'string', 'max' => 300],
            [['PrevPostNm', 'PrevPostStartDt'], 'unique', 'targetAttribute' => ['PrevPostNm', 'PrevPostStartDt']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ICNO' => 'Icno',
            'PrevPostNm' => 'Prev Post Nm',
            'PrevPostStartDt' => 'Prev Post Start Dt',
            'PrevPostEndDt' => 'Prev Post End Dt',
            'PrevPostDesc' => 'Prev Post Desc',
            'id' => 'ID',
        ];
    }
    public function getPrevPostEndDt() {
        return Yii::$app->MP->Tarikh($this->PrevPostEndDt);
    }
    public function getPrevPostStartDt() {
        return Yii::$app->MP->Tarikh($this->PrevPostStartDt);
    }
    
}
