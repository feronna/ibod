<?php
namespace app\models\myidp;

/**
 * This is the model class for table "hronline.gredjawatan".
 *
 * @property int $id
 * @property int $sbpa_id
 * @property string $nama
 * @property string $gred
 * @property string $fname
 * @property string $mymohesCd
 * @property string $short_desc
 * @property int $job_category
 * @property int $job_group kumpkhidmat
 * @property int $cpd_group idp.v_idp_kumpulan
 * @property string $SchmOfServCd
 * @property string $SalGrdId
 * @property int $gred_status
 * @property string $gred_skim
 * @property string $gred_no
 * @property string $idMM
 * @property int $isActive
 * @property int $isKhas
 * @property string $titleMM
 */
class IdpGredJawatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    
    public $min_gredjawatan;
    public $max_gredjawatan;
    
    public static function tableName()
    {
        return 'hronline.gredjawatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sbpa_id', 'job_category', 'job_group', 'cpd_group', 'gred_status', 'isActive', 'isKhas'], 'integer'],
            [['nama', 'fname', 'short_desc'], 'string', 'max' => 255],
            [['gred', 'mymohesCd'], 'string', 'max' => 10],
            [['SchmOfServCd'], 'string', 'max' => 30],
            [['SalGrdId', 'gred_skim'], 'string', 'max' => 5],
            [['gred_no'], 'string', 'max' => 3],
            [['idMM'], 'string', 'max' => 20],
            [['titleMM'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sbpa_id' => 'Sbpa ID',
            'nama' => 'Nama',
            'gred' => 'Gred',
            'fname' => 'Fname',
            'mymohesCd' => 'Mymohes Cd',
            'short_desc' => 'Short Desc',
            'job_category' => 'Job Category',
            'job_group' => 'Job Group',
            'cpd_group' => 'Cpd Group',
            'SchmOfServCd' => 'Schm Of Serv Cd',
            'SalGrdId' => 'Sal Grd ID',
            'gred_status' => 'Gred Status',
            'gred_skim' => 'Gred Skim',
            'gred_no' => 'Gred No',
            'idMM' => 'Id Mm',
            'isActive' => 'Is Active',
            'isKhas' => 'Is Khas',
            'titleMM' => 'Title Mm',
        ];
    }
    
    public function getOrang()
    {
        return $this->hasMany(Tblprcobiodata::className(), ['gredJawatan'=>'id']);
    }
    
    /* Getter for person full name */
    public function StaffAmount($id) {
        
        $amount = \app\models\hronline\Tblprcobiodata::find()
                ->where(['gredJawatan'=>$id])
                ->andWhere(['<>','Status', 6])
                ->count();
        
        return $amount;
    }
    
    public function getJobCategoryy(){
        
        if ($this->job_category == 2){
            return "PENTADBIRAN";
        } elseif ($this->job_category == 1){
            return "AKADEMIK";
        } else {
            return " ";
        }
    }
    
     

}