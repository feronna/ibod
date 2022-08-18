<?php

namespace app\models\elnpt\elnpt2;

use Yii;

use app\models\hronline\Tblrscoadminpost as BaseAdmin;

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
class Tblrscoadminpost extends BaseAdmin {

    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    
}
