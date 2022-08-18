<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "ejobs.cv_tbl_subjpanel".
 *
 * @property int $id
 * @property int $subj_id
 * @property int $jawatan_id
 * @property string $panel_icno
 * @property string $assign_at
 * @property string $assign_by
 */
class TblpSubjekPanel extends \yii\db\ActiveRecord {

     public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
 
    public static function tableName() {
        return 'hrm.cv_tbl_subjpanel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['jawatan_id', 'panel_icno', 'assign_at', 'assign_by'], 'required'],
            [['subj_id', 'jawatan_id'], 'integer'],
            [['assign_at','subj_id'], 'safe'],
            [['panel_icno', 'assign_by'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'subj_id' => 'Subj ID',
            'jawatan_id' => 'Jawatan ID',
            'panel_icno' => 'Panel Icno',
            'assign_at' => 'Assign At',
            'assign_by' => 'Assign By',
        ];
    }

    public function getSubjek() {
        return $this->hasOne(\app\models\ejobs\TblpSubjek::className(), ['id' => 'subj_id']);
    }

    public function getPanel() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'panel_icno']);
    }

    public function getJawatan() {
        return $this->hasOne(\app\models\hronline\GredJawatan::className(), ['id' => 'jawatan_id']);
    }

    public function getLevel() {
        return $this->hasMany(\app\models\ejobs\TblpSubjekLevel::className(), ['subj_id' => 'subj_id']);
    }

    public function getIndicators() {
        return $this->hasMany(\app\models\ejobs\TblpSubjekIndicators::className(), ['subj_id' => 'subj_id']);
    }

    public function getVerifyMark() {
        $model = \app\models\cv\TblpMarkahIv::find()
                ->leftJoin('hrm.cv_temuduga_pentadbiran', 'cv_tbl_markah_iv.gred_id = cv_temuduga_pentadbiran.gred_id')
                ->leftJoin('hrm.cv_tbl_subjpanel', 'cv_temuduga_pentadbiran.gred_id = cv_tbl_subjpanel.jawatan_id')
                ->where(['cv_temuduga_pentadbiran.gred_id' => $this->jawatan_id])
                ->andWhere(['cv_tbl_subjpanel.panel_icno' => $this->panel_icno])
                ->andWhere(['DATE(cv_tbl_subjpanel.assign_at)' => date("Y-m-d")])
                ->one();

        return $model ? true : false;
    }

    public function getTotalIV($id) {

        return \app\models\cv\TblTemudugaPentadbiran::find()->where(['iv_id' => $id])
                        ->count();
    }

    public function getActiveIV($id) {
        $active = \app\models\cv\TemudugaPentadbiran::find()->where(['gred_id' => $id]) 
                ->andWhere(['=', 'DATE(tarikh_iv)', date("Y-m-d")])
                ->one();
        if ($active) {
            return $active->id;
        } else {
            return;
        }
    }
}
