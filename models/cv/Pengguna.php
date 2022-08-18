<?php

namespace app\models\cv;
 
use app\models\hronline\Tblprcobiodata;
use app\models\cv\TblAccess;
use app\models\cv\TblAppinfo;
use app\models\cv\TblPermohonanAc;
use Yii;

class Pengguna extends \yii\db\ActiveRecord {

    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'hrm.cv_pengguna';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['uid'], 'required'],
            [['name', 'sessionid', 'nickname', 'comment', 'panel_comment'], 'string'],
            [['status', 'level', 'approve', 'app_pose', 'pro_type', 'openjob', 'complied_workinghours', 'interview'], 'integer'],
            [['mark', 'final_mark'], 'number'],
            [['lastupdate', 'lastupdatedean'], 'safe'],
            [['uid', 'svc'], 'string', 'max' => 20],
            [['ICNO'], 'string', 'max' => 12],
            [['passwd', 'loginstamp', 'lastloginstamp', 'regstamp', 'xpid'], 'string', 'max' => 100],
            [['ipaddress', 'lastipaddress', 'regip'], 'string', 'max' => 15],
            [['uid'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'uid' => 'Uid',
            'ICNO' => 'Icno',
            'passwd' => 'Passwd',
            'svc' => 'Svc',
            'name' => 'Name',
            'status' => 'Status',
            'ipaddress' => 'Ipaddress',
            'lastipaddress' => 'Lastipaddress',
            'loginstamp' => 'Loginstamp',
            'lastloginstamp' => 'Lastloginstamp',
            'sessionid' => 'Sessionid',
            'regstamp' => 'Regstamp',
            'regip' => 'Regip',
            'level' => 'Level',
            'nickname' => 'Nickname',
            'xpid' => 'Xpid',
            'approve' => 'Approve',
            'comment' => 'Comment',
            'panel_comment' => 'Panel Comment',
            'app_pose' => 'App Pose',
            'pro_type' => 'Pro Type',
            'mark' => 'Mark',
            'final_mark' => 'Final Mark',
            'lastupdate' => 'Lastupdate',
            'lastupdatedean' => 'Lastupdatedean',
            'openjob' => 'Openjob',
            'complied_workinghours' => 'Complied Workinghours',
            'interview' => 'Interview',
        ];
    }

    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    } 

    public function getAppInfo() {
        return $this->hasOne(TblAppinfo::className(), ['uid' => 'uid']);
    }

    public function getAppSubmit() {
        return $this->hasOne(TblPermohonanAc::className(), ['uid' => 'uid']);
    }

    public function submitApplication($gred_apply) {
        $biodata = Tblprcobiodata::findOne(['ICNO' => $this->ICNO]);

        $model = new TblPermohonanAc();
        $model->uid = $this->uid;
        $model->submit_datetime = date('Y-m-d H:i:s');
        $model->gred_apply = $gred_apply;
        $model->current_dept = $biodata->DeptId;
        $model->current_gred = $biodata->gredJawatan;
        $model->dept_hakiki = $biodata->DeptId_hakiki;
        $model->gred_hakiki = $biodata->gredJawatan_2;

        $model->save(false);
        Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Application Submitted']);
    } 

    public function getStatusKj($id) {
        $model = TblPermohonanAc::find()->where(['id' => $id])->one();

        if ($model->kj_status == 1) {
            return '<span class="label label-success">Success</span>';
        } else if ($model->kj_status == 2) {
            return '<span class="label label-danger">Failed</span>';
        } else {
            return;
        }
    }
    
    public function getStatusAdmin($id) {
        $model = TblPermohonanAc::find()->where(['id' => $id])->one();

        if ($model->admin_status == 1) {
            return '<span class="label label-success">Success</span>';
        } else if ($model->admin_status == 2) {
            return '<span class="label label-danger">Failed</span>';
        } else {
            return;
        }
    }

    public function isAdmin() {
        $model = TblAccess::find()->where(['ICNO' => Yii::$app->user->getId()])->one();

        return $model ? 1 : '';
    }

}
