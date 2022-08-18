<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "hrm.cv_ads".
 *
 * @property int $id
 * @property int $gred_id
 * @property string $StartDate
 * @property string $EndDate
 * @property int $isActive
 */
class TblAds extends \yii\db\ActiveRecord {

    public $tarikh;
    public $jawatan = [];

    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'hrm.cv_ads';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['gred_id', 'StartDate', 'EndDate'], 'required'],
            [['gred_id', 'isActive'], 'integer'],
            [['tarikh', 'jawatan', 'StartDate', 'EndDate'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'gred_id' => 'Gred ID',
            'StartDate' => 'Start',
            'EndDate' => 'End',
            'isActive' => 'Is Active',
        ];
    }

    public function findJawatan($id) {
        $model = \app\models\hronline\GredJawatan::find()->where(['id' => $id])->one();

        if ($model) {
            return $model->fname;
        } else {
            return 'Tiada Maklumat';
        }
    }

    public function findCategory($id) {
        $model = \app\models\hronline\GredJawatan::find()->where(['id' => $id])->one();

        return $model->job_category;
    }

    public function getJawatan() {
        return $this->hasOne(\app\models\hronline\GredJawatan::className(), ['id' => 'gred_id']);
    }

    public function getJawatanCv() {
        return $this->hasOne(\app\models\cv\GredJawatan::className(), ['id' => 'gred_id']);
    }

    public function getPermohonan() {
        return $this->hasOne(TblPermohonan::className(), ['ads_id' => 'id']);
    }

    public function getTemuduga() {
        return $this->hasOne(\app\models\cv\TemudugaPentadbiran::className(), ['ads_id' => 'id']);
    }

    public function Total($id) {
        return TblPermohonan::find()
                        ->andWhere(['cv_tbl_permohonan.ads_id' => $id])
                        ->leftJoin('hronline.tblprcobiodata', 'cv_tbl_permohonan.ICNO = tblprcobiodata.ICNO')
//                        ->andWhere(['!=', 'tblprcobiodata.ICNO', Yii::$app->user->getId()])
                        ->count();
    }

    public function TotalWaiting($id) {
        return TblPermohonan::find()
                        ->where(['cv_tbl_permohonan.status_id' => 1])
                        ->andWhere(['cv_tbl_permohonan.ads_id' => $id])
                        ->leftJoin('hronline.tblprcobiodata', 'cv_tbl_permohonan.ICNO = tblprcobiodata.ICNO')
//                        ->andWhere(['!=', 'tblprcobiodata.ICNO', Yii::$app->user->getId()])
                        ->count();
    }

    public function TotalVerify($status, $id, $peraku) {
        return TblPermohonan::find()
                        ->where(['cv_tbl_permohonan.status_id' => $status])
                        ->andWhere(['cv_tbl_permohonan.ads_id' => $id])
                        ->andWhere(['cv_tbl_permohonan.kj_status' => $peraku])
                        ->count();
    }

    public function TotalKjVerify($status, $id) {
        return TblPermohonan::find()
                        ->where(['cv_tbl_permohonan.ads_id' => $id])
                        ->andWhere(['is not', 'cv_tbl_permohonan.kj_datetime', null])
                        ->andWhere(['cv_tbl_permohonan.kj_status' => $status])
                        ->count();
    }
    
    public function TotalDataSaringan($status,$id) {
        return TblPermohonan::find()
                        ->where(['cv_tbl_permohonan.ads_id' => $id])
                        ->andWhere(['is not', 'cv_tbl_permohonan.kj_datetime', null])
                        ->andWhere(['cv_tbl_permohonan.kj_status' => $status]) 
                        ->andWhere(['NOT IN','cv_tbl_permohonan.admin_status', [2,3]])
                        ->count();
    }

    public function TotalAdminPass($id) {
        return TblPermohonan::find()->where(['cv_tbl_permohonan.ads_id' => $id])
                        ->andWhere(['cv_tbl_permohonan.admin_status' => 1])->count();
    }

    public static function category() {
        if (TblPermohonan::isAdminAcademic()) {
            return 1;
        } else {
            return 2;
        }
    }

    public static function findAds() {
        return TblAds::find()
                        ->leftJoin('hronline.gredjawatan', 'cv_ads.gred_id = gredjawatan.id')
                        ->where(['gredjawatan.job_category' => TblAds::category()])
                        ->andWhere(['cv_ads.isActive' => 1])
                        ->orderBy(['gredjawatan.gred' => SORT_ASC]);
    }

    public static function findAdsbySkim() {
        if (TblAccess::isAdminPanelTapisanPen()) {
            $model = TblAccessbySkim::find()->where(['access' => 9, 'ICNO'=>Yii::$app->user->getId()])->all();
        } elseif (TblAccess::isAdminPanelPemilihPen()) {
            $model = TblAccessbySkim::find()->where(['access' => 10, 'ICNO'=>Yii::$app->user->getId()])->all();
        }
        $skim = array();
        foreach ($model as $model){
            $skim[] = $model->ads_id;
        }

        return TblAds::find()
                        ->leftJoin('hronline.gredjawatan', 'cv_ads.gred_id = gredjawatan.id')
                        ->where(['gredjawatan.job_category' => TblAds::category()])
                        ->andWhere(['IN', 'cv_ads.id', $skim])
                        ->andWhere(['cv_ads.isActive' => 1])
                        ->orderBy(['gredjawatan.gred_skim' => SORT_ASC,'gredjawatan.gred_no' => SORT_DESC]);
    }

    public function findActiveAds() {
        $model = TblAds::find()->all();
        $active = array();
        foreach ($model as $model) {
            if ((date('Y-m-d') >= $model->StartDate) && (date('Y-m-d') <= $model->EndDate)) {
                $active[] = $model->id;
            }
        }

        return $active;
    }

    public function getDisplayJawatan() {
        return $this->jawatanCv->fname;
    }

}
