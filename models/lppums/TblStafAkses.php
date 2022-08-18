<?php

namespace app\models\lppums;

use Yii;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "tbl_staf_akses".
 *
 * @property string $ICNO
 * @property int $akses_id
 * @property string $akses_oleh
 */
class TblStafAkses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_staf_akses';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
//    public static function getdb()
//    {
//        return Yii::$app->get('db');
//    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO'], 'required'],
            [['akses_id'], 'integer'],
            [['ICNO', 'akses_oleh'], 'string', 'max' => 12],
            [['ICNO'], 'unique'],
        ];
    }
    
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ICNO' => 'Icno',
            'akses_id' => 'Akses ID',
            'akses_oleh' => 'Akses Oleh',
        ];
    }
    
    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }
}
