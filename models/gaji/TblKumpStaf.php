<?php

namespace app\models\gaji;

use app\models\hronline\Tblprcobiodata;
use Mpdf\Tag\Select;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "hrm.gaji_tbl_kump_staf".
 *
 * @property int $id
 * @property int $kump_id ref tbl_kumpulan (id)
 * @property int $role_id ref ref_role (id)
 * @property string $icno
 * @property string $start_date
 * @property string $end_date
 * @property int $status
 */
class TblKumpStaf extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.gaji_tbl_kump_staf';
    }

    //  untuk convert date
    public function behaviors()
    {
        return [
            'start_date' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['start_date'], // update 1 attribute 'created' OR multiple attribute ['created','updated']
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['start_date'], // update 1 attribute 'created' OR multiple attribute ['created','updated']
                ],
                'value' => function ($event) {
                    return date('Y-m-d', strtotime(str_replace("/", "-", $this->start_date)));
                },
            ],
            'end_date' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['end_date'], // update 1 attribute 'created' OR multiple attribute ['created','updated']
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['end_date'], // update 1 attribute 'created' OR multiple attribute ['created','updated']
                ],
                'value' => function ($event) {

                    if ($this->end_date) {
                        return date('Y-m-d', strtotime(str_replace("/", "-", $this->end_date)));
                    }
                },
            ],
        ];
    }

    public function afterFind()

    {

        $this->start_date = Yii::$app->formatter->asDate($this->start_date, 'dd/MM/yyyy');

        if ($this->end_date) {
            $this->end_date = Yii::$app->formatter->asDate($this->end_date, 'dd/MM/yyyy');
        }

        parent::afterFind();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kump_id', 'role_id', 'status'], 'integer'],
            [['icno', 'role_id', 'start_date'], 'required'],
            [['start_date', 'end_date'], 'safe'],
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
            'kump_id' => 'Kump ID',
            'role_id' => 'Peranan',
            'icno' => 'Nama Staff',
            'start_date' => 'Tarikh Mula',
            'end_date' => 'Tarikh Tamat',
            'status' => 'Status',
        ];
    }

    public function getBiodata()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }

    public function getRoles()
    {
        return $this->hasOne(RefRoles::className(), ['id' => 'role_id']);
    }

    public function getStaffName()
    {
        return $this->biodata->CONm;
    }

    public function getStaffRole()
    {
        return $this->roles->role_name;
    }

    public static function RoleList($icno){
        $roles = self::find()->Select(['role_id','icno'])->distinct()->where(['icno'=>$icno])->all();
        $roles_list_id = ArrayHelper::getColumn($roles, 'role_id', $keepKeys = true);
        $roles_list_name = [];
        for ($i = 0 ; $i < count($roles_list_id); $i++ ) { 
            array_push($roles_list_name,RefRoles::RoleName($roles_list_id[$i]));
        }
        return $roles_list_name;
    }

    
}
