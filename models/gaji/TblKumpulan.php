<?php

namespace app\models\gaji;

use app\models\hronline\Tblprcobiodata;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "hrm.gaji_tbl_kumpulan".
 *
 * @property int $id
 * @property string $nama
 * @property int $status
 * @property string $create_by
 * @property string $create_dt
 * @property string $update_by
 * @property string $update_dt
 */
class TblKumpulan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.gaji_tbl_kumpulan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['create_dt', 'update_dt'], 'safe'],
            [['nama'], 'string', 'max' => 255],
            [['create_by', 'update_by'], 'string', 'max' => 16],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama Kumpulan',
            'status' => 'Status',
            'create_by' => 'Diisi oleh',
            'create_dt' => 'Diisi pada',
            'update_by' => 'Dikemaskini oleh',
            'update_dt' => 'Dikemaskini pada',
        ];
    }

    public function getBioCreate()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'create_by']);
    }

    public function getBioUpdate()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'create_by']);
    }



    /**
     * 
     * Untuk cari role bagi user dlm kumpulan, sekiranya ada role akan return true
     * 
     * usage : TblKumpulan::findRole('911026125488','ENTRY')
     * 
     * icno : No Kad Pengenalan (type char)
     * 
     * role : ENTRY | VERIFY | APPROVE (type char)
     * 
     * return : TRUE : FALSE (type boolean)
     */
    public static function findRole($icno, $role)
    {

        $roles = RefRoles::find()->where(['role_name' => $role])->one();

        if ($roles) {
            $staff = TblKumpStaf::find()->where(['icno' => $icno, 'role_id' => $roles->id])->one();


            if ($staff) {
                return true;
            }
        }

        return false;
    }

    /**
     * 
     * Untuk cari role bagi user dlm kumpulan dan return array jenis2 lpg yang ada dlm kumpulan
     * 
     * usage : TblKumpulan::findRole('911026125488','ENTRY')
     * 
     * icno : No Kad Pengenalan (type char)
     * 
     * role : ENTRY | VERIFY | APPROVE (type char)
     * 
     * singleArray : True = return RR_REASON_CODE sahaja || False = return key => value array
     * 
     * return : [
     * 11 => 'PERGERAKAN GAJI BIASA'
     * 12 => 'PERGERAKAN ANJAKAN GAJI'
     * 10 => 'KENAIKAN PANGKAT JAWATAN'
     * 1 => 'BERCUTI BELAJAR'
     * 13 => 'PERGERAKAN GAJI SEBENAR'
     * ] (type Array)
     */
    public static function lpgListByRole($icno, $role, $singleArray = false)
    {
        $roles = RefRoles::find()->where(['role_name' => $role])->one();

        $arr = [];

        if ($roles) {
            $staff = TblKumpStaf::find()->where(['icno' => $icno, 'role_id' => $roles->id])->one();
            if ($staff) {


                $lpg = TblKumpLpg::find()->where(['kump_id' => $staff->kump_id])->all();

                $arr = ArrayHelper::map($lpg, 'RR_REASON_CODE', 'lpgName');

                if ($singleArray == true) {
                    $arr = ArrayHelper::getColumn($lpg, 'RR_REASON_CODE', $keepKeys = true);
                }

                return $arr;
            }
        }

        return $arr;
    }
}
