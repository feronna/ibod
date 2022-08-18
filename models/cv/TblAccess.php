<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "cv.tbl_access".
 *
 * @property int $id
 * @property string $ICNO
 */
class TblAccess extends \yii\db\ActiveRecord {

    public $skim = [];

    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'hrm.cv_tbl_access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['ICNO'], 'required',],
            [['ICNO'], 'string', 'max' => 12],
            [['access', 'skim'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'ICNO' => 'Name',
        ];
    }

    public function isAdmin() {
        return TblAccess::find()->where(['ICNO' => Yii::$app->user->getId()])->exists();
    }

    public function getBiodata() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }

    public static function getAksesPentadbiran() {
        $model = TblAccess::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['IN', 'access', [6, 9, 10]])->one();
        return $model ? $model->access : 0;
    }

    public static function isSuperAdmin() {
        return TblAccess::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['access' => 1])->exists();
    }

    public static function isAdminAcademic() {
        return TblAccess::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['access' => 2])->exists();
    }

    public static function isAdminDataOwner() {
        return TblAccess::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['access' => 3])->exists();
    }

    public static function isAdminNonAcademic() {
        return TblAccess::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['access' => 5])->exists();
    }

    public static function isAdminPanel() {
        return TblAccess::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['access' => 6])->exists();
    }

    public static function isAdminPanelTapisan() {
        return TblAccess::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['access' => 7])->exists();
    }

    public static function isAdminPanelPemilih() {
        return TblAccess::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['access' => 8])->exists();
    }

    public static function isAdminPanelTapisanPen() {
        return TblAccess::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['access' => 9])->exists();
    }

    public static function isAdminPanelPemilihPen() {
        return TblAccess::find()->where(['ICNO' => Yii::$app->user->getId()])->andWhere(['access' => 10])->exists();
    }

    public static function isExternalUner() {
        return \app\models\system_core\ExternalUser::findOne(['user_id' => Yii::$app->user->getId()]);
    }

    public function getLevel() {
        return $this->hasOne(RefAccess::className(), ['id' => 'access']);
    }

    public function getDisplaySkim() {
        $model = TblAccessbySkim::find()->where(['access' => $this->access, 'ICNO' => $this->ICNO])->all();
        $arr = '';
        if ($model) {
            $i = 1;
            foreach ($model as $model) {
                $arr .= $i . '. ' . $model->ads->jawatanCv->fname . '<br/>';

                $i++;
            }
        }
        return $arr;
    }
    
    public static function checkAccess() {
        $status = false;
        if (TblAccess::findOne(['ICNO' => Yii::$app->user->getId()])) {
            $status = true;
        }
        
        if (\app\models\pengesahan\TblAdmin::findOne(['icno' => Yii::$app->user->getId()])) {
            $status = true;
        }
        
        if (\app\models\pengesahan\TblAccessCanselori::findOne(['icno' => Yii::$app->user->getId()])) {
            $status = true;
        }
        
        return $status;
    }

}
