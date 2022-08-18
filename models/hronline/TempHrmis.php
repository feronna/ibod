<?php

namespace app\models\hronline;
use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "hronline.temp_hrmis".
 *
 * @property int $id
 * @property string $icno
 */
class TempHrmis extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.temp_hrmis';
    }
    
       public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
        ];
    }
    
        public function getKakitangan()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
}
