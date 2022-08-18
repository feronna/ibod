<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.servicestatus".
 *
 * @property int $ServStatusCd
 * @property string $ServStatusNm
 * @property string $ServStatusCdMM
 */
class ServiceStatus extends \yii\db\ActiveRecord
{
    
    public $_totalAktif;


    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.servicestatus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ServStatusCd'], 'required'],
            [['ServStatusCd'], 'integer'],
            [['ServStatusNm'], 'string', 'max' => 255],
            [['ServStatusCdMM'], 'string', 'max' => 20],
            [['ServStatusCd'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ServStatusCd' => 'Serv Status Cd',
            'ServStatusNm' => 'Serv Status Nm',
            'ServStatusCdMM' => 'Serv Status Cd Mm',
        ];
    }

    public function getBiodata(){
        return $this->hasMany(Tblprcobiodata::className(), ['Status' => 'ServStatusCd']);
    }
    public function getServiceStatus($gredJawatan = null, $jobcategory = null, $job_group = null, $statLantikan = null){
        $query = GredJawatan::find()->joinWith('biodata.serviceStatus')->select('`id`,`nama`,`gred`,count(`tblprcobiodata`.`ICNO`) AS `_totalCount`,count(`ServiceStatus`.`ServStatusCd`) AS `_totalAktif`,')->where(['`gredJawatan`.`job_category`'=>'1'])
        ->andWhere(['`gredJawatan`.`job_group`'=>1])->andWhere(['`tblprcobiodata`.`statLantikan`'=> 1])
        ->andWhere(['!=','`tblprcobiodata`.`Status`','06'])->orderBy(['id'=>SORT_ASC])->groupBy('nama');
    }
}
