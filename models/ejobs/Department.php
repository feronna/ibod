<?php

namespace app\models\ejobs;

use Yii;

/**
 * This is the model class for table "hronline.department".
 *
 * @property int $id
 * @property string $fullname
 * @property string $shortname
 * @property string $chief
 * @property string $mymohesCd
 * @property int $category_id
 * @property string $pp
 * @property string $bos
 * @property int $isActive 1=Aktif, 0=Tidak Aktif
 * @property string $idMM
 * @property int $cluster 1=science, 2=non-science
 * @property int $dept_cat_id rujuk dept_cat | added by miji 1/9/2015
 * @property int $sub_of Kod JFPIU Utama
 * @property string $address Alamat
 * @property string $fax_no No.Faks
 * @property string $tel_no No.Telefon
 * @property string $pa_email Emel PA
 */
class Department extends \yii\db\ActiveRecord {

    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'ejobs.department';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['category_id', 'isActive', 'cluster', 'dept_cat_id', 'sub_of'], 'integer'],
                [['address'], 'string'],
                [['fullname'], 'string', 'max' => 300],
                [['shortname', 'chief'], 'string', 'max' => 60],
                [['mymohesCd'], 'string', 'max' => 4],
                [['pp', 'bos'], 'string', 'max' => 12],
                [['idMM'], 'string', 'max' => 20],
                [['fax_no', 'tel_no', 'pa_email'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'fullname' => 'JFPIU',
            'shortname' => 'JFPIU',
            'chief' => 'Chief',
            'mymohesCd' => 'Mymohes Cd',
            'category_id' => 'Category ID',
            'pp' => 'Pp',
            'bos' => 'Bos',
            'isActive' => 'Is Active',
            'idMM' => 'Id Mm',
            'cluster' => 'Cluster',
            'dept_cat_id' => 'Dept Cat ID',
            'sub_of' => 'Sub Of',
            'address' => 'Address',
            'fax_no' => 'Fax No',
            'tel_no' => 'Tel No',
            'pa_email' => 'Pa Email',
        ];
    }
	 
}
