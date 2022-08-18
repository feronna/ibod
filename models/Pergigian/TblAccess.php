<?php

namespace app\models\Pergigian;
use app\models\hronline\Tblprcobiodata;

use Yii;

/**
 * This is the model class for table "pergigian.tbl_access".
 *
 * @property int $id
 * @property string $icno
 * @property int $access_level 1=admin, 2=penyemak, 3=pelulus, 4=bendahari
 * @property int $is_active active = 1, inactive = 0
 */
class TblAccess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.gigi_tbl_access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['access_level', 'is_active'], 'integer'],
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
            'access_level' => 'Access Level',
            'is_active' => 'Is Active',
        ];
    }
    
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
    public function getAccessLevel() {

        if ($this->access_level == 1) {
            return '&nbsp;<span class="badge bg-red">Administrator</span>';
        }
        if ($this->access_level == 2) {
            return '&nbsp;<span>Penyemak</span>';
        }
        if ($this->access_level == 3) {
            return '&nbsp;<span >Pelulus</span>';
        }
        if ($this->access_level == 4) {
            return '&nbsp;<span >Bendahari</span>';
        }
    }
    
    public function getStatus() {
        if ($this->is_active == 1) {
            return '&nbsp;<span >Aktif</span>';
        } else {
            return '&nbsp;<span >Tidak Aktif</span>';
        }
    }
}
