<?php

namespace app\models\utilities\epos;

use Yii;
use app\models\hronline\Tblprcobiodata;
/**
 * This is the model class for table "utilities.pos_tbl_akses".
 *
 * @property int $id
 * @property string $icno
 * @property int $DeptId
 * @property int $status 1 = Aktif; 0 = Tidak Aktif
 * @property string $update_by
 * @property string $update_dt
 * @property int $access_level
 */
class TblAkses extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'utilities.pos_tbl_akses';
    }

    public function rules()
    {
        return [
            [['DeptId', 'status', 'access_level'], 'integer'],
            [['update_dt'], 'safe'],
            [['icno', 'update_by'], 'string', 'max' => 12],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'DeptId' => 'Dept ID',
            'status' => 'Status',
            'update_by' => 'Update By',
            'update_dt' => 'Update Dt',
            'access_level' => 'Access Level',
        ];
    }
      public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }

    public static function PelulusJabatan($DeptId){
        if(($model = self::find()->where(['DeptId'=>$DeptId])->andWhere(['and',['status'=>1],['access_level'=>2]])->one()) !== null){
            return $model;
        }
        return null;
    }
    public static function AdminEpos(){
        if(($model = self::find()->Where(['and',['status'=>1],['access_level'=>3]])->one()) !== null){
            return $model;
        }
        return null;
    }
}
