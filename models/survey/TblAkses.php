<?php

namespace app\models\survey;

use app\models\hronline\Department;
use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "hrm.survey_tbl_akses".
 *
 * @property int $id
 * @property string $icno
 * @property int $akses 1 = induk | 2 = jfpib
 * @property int $status 0 = x Aktif | 1 = Aktif
 */
class TblAkses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.survey_tbl_akses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['akses', 'status'], 'integer'],
            [['icno'], 'string', 'max' => 16],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Nama Staffr',
            'akses' => 'Jenis Akses',
            'status' => 'Status',
        ];
    }

    public function getJenisAkses(){
        if($this->akses == 1){
            return 'Urusetia Induk';
        }

        if($this->akses == 2){
            return 'Urusetia JFPIB';
        }

    }

    public function getKakitangan()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }

    /**
     * ni utk urusetia induk atau pun admin
     */
    public static function isUserAdmin($userid)
    {

        $model = self::findOne(['icno' => $userid, 'akses' => 1, 'status' => 1]);

        if ($model) {
            return true;
        }

        return false;
    }


    /**
     * ni utk urusetia JFPIB
     */
    public static function isUserUrusetia($userid)
    {

        $model = self::findOne(['icno' => $userid, 'akses' => 2, 'status' => 1]);

        if ($model) {
            return true;
        }

        return false;
    }

    /**
     * ni utk KJ atau dekan
     */
    public static function isUserKj($userid)
    {

        $model = Department::findOne(['chief' => $userid]);

        if ($model) {
            return true;
        }

        return false;
    }

    /**
     * ni utk KJ atau dekan
     */
    public static function isUserVc($userid)
    {

        $model = Tblprcobiodata::findOne(['ICNO' => $userid, 'gredJawatan' => 2]);

        if ($model) {
            return true;
        }

        return false;
    }
}
