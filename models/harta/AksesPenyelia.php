<?php

namespace app\models\harta;

use Yii;

/**
 * This is the model class for table "hrm.harta_akses_penyelia".
 *
 * @property int $id
 * @property string $akses_icno
 * @property int $jenis_akses
 * @property string $akses_dept
 * @property string $akses_campus
 */
class AksesPenyelia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.harta_akses_penyelia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenis_akses'], 'integer'],
            [['akses_icno'], 'string', 'max' => 15],
            [['akses_dept', 'akses_campus'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'akses_icno' => 'Akses Icno',
            'jenis_akses' => 'Jenis Akses',
            'akses_dept' => 'Akses Dept',
            'akses_campus' => 'Akses Campus',
        ];
    }
    
        public function getPenyeliaBiodata() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'akses_icno']);
    }
    
       public function getPenyeliaDepartment() {
        return $this->hasOne(\app\models\hronline\Department::className(), ['id' => 'akses_dept']);
    }
    
       public function getPenyeliaCampus() {
        return $this->hasOne(\app\models\hronline\Campus::className(), ['campus_id' => 'akses_campus']);
    }
    
}
