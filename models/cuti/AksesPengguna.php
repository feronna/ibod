<?php

namespace app\models\cuti;

use app\models\hronline\Campus;
use app\models\hronline\Department;
use app\models\hronline\GredJawatan;
use app\models\hronline\Tblprcobiodata;
use app\models\system_core\TblUserAccess;
use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "e_cuti.akses_pengguna".
 *
 * @property int $akses_cuti_id
 * @property string $akses_cuti_icno
 * @property int $akses_cuti_int
 * @property int $akses_jspiu_id
 * @property int $akses_kampus_id
 */
class AksesPengguna extends \yii\db\ActiveRecord
{

    // add the function below:
    // public static function getDb()
    // {
    //     return Yii::$app->get('db2'); // second database
    // }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cuti_access';
        // return 'e_cuti.akses_pengguna';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['akses_cuti_int', 'akses_jspiu_id', 'akses_kampus_id'], 'integer'],
            [['akses_cuti_icno'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'akses_cuti_id' => 'Akses Cuti ID',
            'akses_cuti_icno' => 'Akses Cuti Icno',
            'akses_cuti_int' => 'Akses Cuti Int',
            'akses_jspiu_id' => 'Akses Jspiu ID',
            'akses_kampus_id' => 'Akses Kampus ID',
        ];
    }
    public function getSlverifier()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'akses_cuti_icno']);
    }

    public function getJawatan()
    {
        // var_dump($this->slverifier->gredJawatan);die;
        $s = GredJawatan::findOne(['id' => $this->slverifier->gredJawatan]);

        return  $s->fname;
    }
    public function getDepartment()
    {
        // var_dump($this->slverifier->gredJawatan);die;
        return $this->hasOne(Department::className(), ['id' => 'akses_jspiu_id']);
    }
    public function getCampus()
    {
        // var_dump($this->slverifier->gredJawatan);die;
        return $this->hasOne(Campus::className(), ['campus_id' => 'akses_kampus_id']);
    }
    public function getAccess()
    {
        // var_dump($this->slverifier->gredJawatan);die;
        if ($this->akses_cuti_int == 2) {
            return 'Penyelia Cuti';
        } else {
            return 'Admin';
        }
    }

    public static function Admin($id)
    {
        $btn = Html::a('<i class="fa fa-minus">', ["cuti/admin/add-supervisor", 'id' => $id]);
        $admin = AksesPengguna::find()->where(['akses_cuti_icno' => $id])->one();
        if ($admin) {
            return Html::a('<i class="fa fa-user">', ["cuti/admin/update-access", 'id' => $admin->akses_cuti_id]);;
        } else {
            return $btn;
        }
    }

    public static function visible($id, $cat)
    {

        if ($cat == 1) {
            $admin = AksesPengguna::find()->where(['akses_cuti_icno' => $id])->andWhere(['akses_cuti_int' => 3])->exists();
        } elseif ($cat == 2) {
            $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);
            if ($biodata->statLantikan == 1) {
                $admin = true;
            } else {
                $admin = false;
            }
        } elseif ($cat == 3) {
            $admin = Department::find()->where(['chief' => $id])->andWhere(['id' => 158])->exists();
        } elseif ($cat == 5) {
            $kk = CutiTempTable::findOne(['icno'=>$id,'allowed'=>1]);
            if($kk){
                $admin = true;
            }else{
                $admin = CutiOpenApplication::find()->where(['status' => 1])->andWhere(['>','end_date',date('Y-m-d')])->exists();

            }
        }elseif ($cat == 6) {
            $admin = AksesPengguna::find()->where(['akses_cuti_int' => 3])->andWhere(['akses_jspiu_id'=>158])->exists();
        }elseif($cat == 7){
            $admin = Department::find()->where(['pp' => $id])->exists();
            if(!$admin){
                $admin = Department::find()->where(['chief' => $id])->exists();

            }
        }
         else {
            $admin = AksesPengguna::find()->where(['akses_cuti_icno' => $id])->exists();
        }
        if ($admin) {

            return true;
        } else {
            return false;
        }
    }



    /**
     * return list of staff according to penyelia akses dept and campus
     * klu ada deptID x perlu lg parameter yg 1st dgn 2nd
     */
    public static function kakitanganSeliaan($icno, $otherCondition = [], $deptId = null, $otherCondition2 = [])
    {

        $arr_dept = [];
        $arr_campus = [];

        $akses = AksesPengguna::find()->where(['akses_cuti_icno' => $icno])->all();

        foreach ($akses as $r) {
            $arr_dept[] = $r->akses_jspiu_id;
        }

        foreach ($akses as $t) {
            $arr_campus[] = $t->akses_kampus_id;
        }

        if ($deptId) {
            $staff = Tblprcobiodata::find()->where(['DeptId' => $deptId, 'Status' => 1])
                ->orderBy(['CONm' => SORT_ASC])->all();
        } else {
            $staff = Tblprcobiodata::find()->where(['DeptId' => $arr_dept, 'Status' => 1])
                ->andWhere(['campus_id' => $arr_campus])
                ->andWhere($otherCondition)
                ->andFilterWhere($otherCondition2)
                ->orderBy(['CONm' => SORT_ASC])->all();
        }

        return $staff;
    }
}
