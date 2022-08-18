<?php

namespace app\models\kemudahan;
use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "facility.ref_pegawai2".
 *
 * @property int $id
 * @property string $icno
 * @property string $admin_post
 * @property int $isActive
 */
class RefPegawai2 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'facility.ref_pegawai2';
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
            'admin_post' => 'Admin Post',
            'isActive' => 'Is Active',
        ];
    }
      public function getPegawai(){
        return $this->hasOne(Tblprcobiodata::className(), ['icno' => 'icno']);
    }
}
