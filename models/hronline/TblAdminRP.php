<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.adminrp".
 *
 * @property int $id
 * @property string $icno
 * @property int $access_type 1=s,v;2=s,v,rp
 */
class TblAdminRP extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
 
    public static function tableName()
    {
        return 'hronline.adminrp';
    }


    public function rules()
    {
        return [
            [['access_type','isActive'], 'integer'],
            [['icno'], 'string', 'max' => 12],
            [['icno', 'access_type'], 'required', 'message'=>'Ruang ini adalah mandatori.'],
            [['icno'], 'unique', 'message'=>'Pengguna ini sudah wujud dalam senarai akses.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'access_type' => 'Access Type',
        ];
    }
}
