<?php

namespace app\models\allocation;

use app\models\hronline\Department;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%hrm.alloc_tbl_profiles}}".
 *
 * @property int $id
 * @property string $icno
 * @property string $start_date
 * @property string $jenis_lantikan UMS / HUMS
 * @property int $sumber_peruntukan 1=Pusat Kos / 2=EKT / 3=EKK / 4=Tabung Amanah / 5=Projek
 * @property string $pusat_kos
 * @property int $status_kontrak 1 = Pusat / 2 = Atas Waran
 */
class TblProfiles extends \yii\db\ActiveRecord
{
    public static function getDb()
    {
        //letak dlu sementara d hronline
        return Yii::$app->get('db2');
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hronline.alloc_tbl_profiles}}';
    }

    public function getDepartment()
    {
        return $this->hasOne(Department::class, ['id' => 'pusat_kos']);
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
        ];
    }

    public function afterFind()
    {

        $this->start_date = Yii::$app->formatter->asDate($this->start_date, 'dd/MM/yyyy');

        return true;
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start_date'], 'required'],
            [['start_date'], 'safe'],
            [['sumber_peruntukan', 'status_kontrak'], 'integer'],
            [['icno'], 'string', 'max' => 16],
            [['jenis_lantikan'], 'string', 'max' => 5],
            [['pusat_kos'], 'string', 'max' => 20],
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
            'start_date' => 'Start Date',
            'jenis_lantikan' => 'Jenis Lantikan',
            'sumber_peruntukan' => 'Sumber Peruntukan',
            'pusat_kos' => 'Pusat Kos',
            'status_kontrak' => 'Status Kontrak',
        ];
    }

    public function arrSumberPeruntukan($id = null)
    {
        $arr = [
            1 => 'Emolumen Kakitangan Tetap (EKT)',
            2 => 'Emolumen Kakitangan Kontrak (EKK)',
            3 => 'Tabung Amanah',
            4 => 'Pusat Kos',
            5 => 'Projek',
        ];

        if ($id) {
            return $arr[$id];
        }

        return $arr;
    }

    public function arrStatusKontrak($id = null)
    {
        $arr = [
            1 => 'Kontrak Pusat',
            2 => 'Kontrak Atas Waran',
            3 => 'Kontrak Jabatan',
        ];

        if ($id) {

            return $arr[$id];
        }

        return $arr;
    }

    public function getLabelSumberPeruntukan()
    {
        return $this->sumber_peruntukan ? $this->arrSumberPeruntukan($this->sumber_peruntukan) : '-- N/A --';
    }

    public function getLabelStatusKontrak()
    {
        return $this->status_kontrak ? $this->arrStatusKontrak($this->status_kontrak) : '-- N/A --';
    }

    public function getLabelPusatKos()
    {
        return $this->pusat_kos ? $this->department->fullname : ' - ';
    }

    public static function isUserAdmin($icno)
    {

        if ($icno == '811212125745') {
            return true;
        }
        if ($icno == '890426495037') {
            return true;
        }
        if ($icno == '840813125655') {
            return true;
        }
        if ($icno == '880625125056') { //ayu
            return true;
        }
        if ($icno == '851129125038') { //nana
            return true;
        }
        if ($icno == '810301125603') { //adrian
            return true;
        }
        if ($icno == '760210125453') { //shanon
            return true;
        }
        if ($icno == '850711125215') { //razmi
            return true;
        }
        if ($icno == '701203106182') { //CK
            return true;
        }
        if ($icno == '800505125358') { //rozaidah
            return true;
        }

        return false;
    }
}
