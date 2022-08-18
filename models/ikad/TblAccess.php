<?php

namespace app\models\ikad;

use app\models\hronline\GredJawatan;
use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "ikad.ikad_tbl_access".
 *
 * @property int $id
 * @property string $ICNO
 * @property int $accesstype 0-penyemak, 1-peraku
 * @property int $isActive 1-active,0-not active
 */
class TblAccess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.ikad_tbl_access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['accesstype', 'isActive'], 'integer'],
            [['datecreated'], 'safe'],
            [['ICNO','added_by'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'accesstype' => 'Accesstype',
            'isActive' => 'Is Active',
        ];
    }
    public function getGreds()
    {
        $bio = $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
        // var_dump($bio);die;
        return $this->hasOne(GredJawatan::className(), ['id' => $bio->gredJawatan]);
    }
    public function getKakitangan()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }
    public function getStatus()
    {
        $lang = "";

        
        if ($this->isActive == '1') {
            $lang = 'Active';
        }
        if ($this->isActive == '0') {
            $lang = 'Not Active';
        }
       

        return $lang;
    }
    public function getRoles()
    {
        $lang = "";

        
        if ($this->accesstype == '0') {
            $lang = 'Pegawai Penyemak';
        }
        if ($this->accesstype == '1') {
            $lang = 'Pegawai Peraku';
        }
       

        return $lang;
    }
}
