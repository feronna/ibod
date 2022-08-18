<?php

namespace app\models\cuti;

use app\models\hronline\Gelaran;
use app\models\hronline\GredJawatan;
use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "hrm.cuti_tbl_management".
 *
 * @property int $id
 * @property string $icno
 * @property int $level 0 - penyelia bsm , 1 - pegawai cuti
 * @property int $isActive
 */
class TblManagement extends \yii\db\ActiveRecord
{
    public $pegawai2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cuti_tbl_management';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['level', 'isActive'], 'integer'],
            [['icno'], 'string', 'max' => 12],
            [['user'], 'string', 'max' => 15],
            [['title'], 'string'],
            [['tarikh_AP','update_by','update_at','pegawai2'],'safe']
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
            'level' => 'Level',
            'isActive' => 'Is Active',
        ];
    }
    public function getKakitangan()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    public function getGelaran()
    {
        return $this->hasOne(Gelaran::className(), ['TitleCd' => 'TitleCd']);
    }
    public function getJawatan()
    {
        return $this->hasOne(GredJawatan::className(), ['id' => 'gredJawatan']);
    }
    public function getLevels(){
        $val = '';
        if($this->level == 0){
            $val = 'Penyelia';
        }else{
            $val = 'pegawai';
        }
        return $val;
    }
}
