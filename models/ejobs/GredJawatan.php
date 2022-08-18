<?php

namespace app\models\ejobs;

use Yii;

/** 
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
class GredJawatan extends \yii\db\ActiveRecord {

    public $jawatan;
    public $jawatanArr = [];
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'ejobs.gredjawatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['jawatan','jawatanArr','sbpa_id', 'job_category', 'job_group', 'cpd_group', 'gred_status', 'isActive', 'isKhas'], 'integer'],
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
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'sbpa_id' => 'Sbpa ID',
            'nama' => 'Nama',
            'gred' => 'Gred',
            'fname' => 'Gred / Position',
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
    
    public function getQuestion() {
        return $this->hasMany(\app\models\ejobs\TblpQuestion::className(), ['jawatan_id' => 'id']);
    }
    
    public function getTugas() {
        return $this->hasMany(\app\models\ejobs\TugasJawatan::className(), ['jawatan_id' => 'id']);
    }
    
    public function getKelayakan() {
        return $this->hasMany(\app\models\ejobs\Kelayakan::className(), ['jawatan_id' => 'id']);
    }
    
    public function getBiodata() {
        return $this->hasOne(\app\models\ejobs\TblprcobiodataTemp::className(), ['gredJawatan' => 'id']);
    }
    
    public function getIklan() {
        return $this->hasOne(\app\models\ejobs\Iklan::className(), ['jawatan_id' => 'id']);
    }

}
