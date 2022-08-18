<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.addresstype".
 *
 * @property string $AddrTypeCd
 * @property string $AddrType
 */
class JenisAlamat extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }

    public static function tableName()
    {
        return 'hronline.addresstype';
    }

    public function rules()
    {
        return [
            [['AddrTypeCd','AddrType'], 'required', 'message'=>'Ruang ini adalah mandatori'],
            [['AddrTypeCd'], 'string', 'max' => 2],
            [['AddrType'], 'string', 'max' => 255],
            [['AddrTypeCd'], 'unique'],
            [['isActive'],'integer','max'=>1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'AddrTypeCd' => 'Addr Type Cd',
            'AddrType' => 'Addr Type',
        ];
    }
    
    public function getStatus() {
        return $this->isActive ? "Aktif" : "Tidak Aktif";
    }
}
