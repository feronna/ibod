<?php

namespace app\models\hronline;

use Yii;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "hronline.Tblvaksinasi".
 *
 * @property string $icno
 * @property int $mysj_id_st 0=tiada;1=ada
 * @property int $daftar_st 0=belum daftar;1=sudah daftar
 * @property string $sebab_1 sebab belum daftar
 * @property int $setuju_st 0=tidak setuju;1=setuju
 * @property string $sebab_2 sebab tidak setuju
 * @property string $kemaskini_dt tarikh terakhir kemaskini
 */
class Tblvaksinasi extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }

    public $mysj_id;

    public static function tableName()
    {
        return 'hronline.tblvaksinasi';
    }

    public function rules()
    {
        return [
            [['icno','mysj_id'], 'required', 'message'=>'Ruangan ini adalah mandatori.'],
            [['mysj_id_st', 'daftar_st', 'setuju_st'], 'integer'],
            [['kemaskini_dt'], 'safe'],
            [['icno'], 'string', 'max' => 20],
            [['sebab_1', 'sebab_2'], 'string', 'max' => 255],
            [['icno'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'icno' => 'Icno',
            'mysj_id_st' => 'Mysj ID Status',
            'daftar_st' => 'Daftar St',
            'sebab_1' => 'Sebab belum daftar',
            'setuju_st' => 'Setuju St',
            'sebab_2' => 'Sebab tidak setuju',
            'kemaskini_dt' => 'Kemaskini Dt',
        ];
    }

    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }

    public static function isRegistered($icno){
        $model = Tblvaksinasi::find()->where(['icno'=>$icno])->exists();
        if($model){
            return true;
        }
        return false;
    }
}
