<?php

namespace app\models\kemudahan;
use app\models\hronline\Tblprcobiodata;
 

/**
 * This is the model class for table "facility.tbl_access".
 *
 * @property int $id
 * @property string $icno
 * @property int $admin_post
 * @property int $isActive
 */
class TblAccess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.fac_tbl_access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['isActive'], 'integer'],
            [['icno'], 'string', 'max' => 12],
            [['admin_post'], 'string', 'max' => 50],
            [['nama'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama Kakitangan',
            'icno' => 'Icno',
            'admin_post' => 'Admin Post',
            'isActive' => 'Is Active',
        ];
    }
    public function getPegawai(){
        return $this->hasOne(Tblprcobiodata::className(), ['icno' => 'icno']);
    }
    
    public function getRefakses()
    {
        return $this->hasOne(Refaccess::className(), ['access_level' => 'admin_post']);
//        return $this->hasOne(Refaccess::className(), ['admin_post' => 'access_level']);

    }
}
