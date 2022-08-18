<?php

namespace app\models\hronline;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "hronline.tblprclinicalcert".
 *
 * @property int $id
 * @property int $icno
 * @property string $title
 * @property int $type
 * @property string $dateAwd
 * @property string $certNo
 * @property string $validity
 * @property string $awardBy
 * @property string $proof
 */
class Tblprclinicalcert extends \yii\db\ActiveRecord {

    public $file;

    public static function tableName() {
        return 'hronline.tblprclinicalcert';
    }

    public static function getDb() {
        return Yii::$app->get('db2');
    }

    public function rules() {
        return [
            [['type'], 'integer'],
            [['icno'], 'string', 'max' => 15],
            [['dateAwd', 'startDt', 'endDt'], 'safe'],
            [['title', 'certNo', 'awardBy'], 'string', 'max' => 255],
            [['proof'], 'string', 'max' => 100],
            [['file'], 'required', 'on' => 'add', 'message' => 'Ruang ini adalah mandatori.'],
            [['file'], 'file', 'extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'maxSize' => 6666240, 'tooBig' => 'Limit is 6MB'],
            [['isVerified'], 'integer'],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'icno' => 'NO. KP/IC',
            'title' => 'Title',
            'type' => 'Type',
            'dateAwd' => 'Date Awd',
            'certNo' => 'Cert No',
            'startDt' => 'Start Date',
            'endDt' => 'End Date',
            'awardBy' => 'Award By',
            'proof' => 'Proof',
        ];
    }

    public function getFullDate() {
        return Yii::$app->MP->Tarikh($this->startDt) . ' - ' . Yii::$app->MP->Tarikh($this->endDt);
    }

    public function getCertType() {
        return $this->hasOne(certificateType::className(), ['id' => 'type']);
    }

    public function getIsverified() {
        if ($this->isVerified) {
            return '<span class="label label-success">Telah disahkan</span>';
        }
        return '<span class="label label-warning">Belum disahkan</span>';
    }

    public function getDisplayLink() {
        if (!empty($this->proof) && $this->proof != 'deleted') {
            return html::a(Yii::$app->FileManager->NameFile($this->proof), Yii::$app->FileManager->DisplayFile($this->proof), ['target' => '_blank']);
        }
        return 'File not exist!';
    }

    //log for Create, update or delete data.
    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $changes = [];
        $tempObj = self::findOne(['id' => $this->id]);
        $attrib = $this->activeAttributes();

        switch ($insert) {
            case (false):
                $activity = 1;
                for ($i = 0; $i < count($attrib); $i++) {

                    if ($tempObj->{$attrib[$i]} != $this->{$attrib[$i]}) {
                        array_push($changes, [$attrib[$i], $tempObj->{$attrib[$i]}, $this->{$attrib[$i]}]);
                    }
                }
                break;

            default:
                //aftersave will handle it
                break;
        }
        if (count($changes) > 0) {
            //log activity to updatestatus table
            $log = new Updatestatus();
            $log->usern = $tempObj->icno; //Yii::$app->user->getId();
            $log->COTableName = $this->tableName();
            $log->COActivity = $activity;
            $log->COUpadteDate = date('Y-m-d H:i:s');
            $log->COUpdateIP = Yii::$app->request->getRemoteIP();
            $log->COUpdateComp = Yii::$app->request->getRemoteIP();
            $log->COUpdateCompUser = Yii::$app->user->getId();
            $log->COUpdateSQL = serialize($changes);
            $log->idval = $this->id;
            $log->save(false);

            //save to tbl_stat
            $stat = Tblstat::find()->where(['ICNO' => $this->icno, 'table' => $this->tableName(), 'idval' => $this->id])->one();
            if ($stat == null) {
                $stat = new Tblstat();
                $stat->ICNO = $this->icno;
                $stat->table = $this->tableName();
                $stat->idval = $this->id;
            }
            $stat->status = 1;
            $stat->date_submit = date('Y-m-d H:i:s');
            $stat->save(false);

            // Yii::$app->MP->BiodataLastUpdate($this->ICNO);
        }

        return true;
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            //save to tbl_stat
            $stat = new Tblstat();
            $stat->ICNO = $this->icno;
            $stat->table = $this->tableName();
            $stat->idval = $this->id;
            $stat->status = 0;
            $stat->date_submit = date('Y-m-d H:i:s');
            $stat->save(false);

            $changes = [];
            //$tempObj = self::findOne(['id' => $this->id]);
            $attrib = $this->activeAttributes();
            $activity = 0;

            for ($i = 0; $i < count($attrib); $i++) {
                array_push($changes, [$attrib[$i], $this->{$attrib[$i]}]);
            }

            $log = new Updatestatus();
            $log->usern = $this->icno; //Yii::$app->user->getId();
            $log->COTableName = $this->tableName();
            $log->COActivity = $activity;
            $log->COUpadteDate = date('Y-m-d H:i:s');
            $log->COUpdateIP = Yii::$app->request->getRemoteIP();
            $log->COUpdateComp = Yii::$app->request->getRemoteIP();
            $log->COUpdateCompUser = Yii::$app->user->getId();
            $log->COUpdateSQL = serialize($changes);
            $log->idval = $this->id;
            $log->save(false);

            // Yii::$app->MP->BiodataLastUpdate($this->ICNO);
        }

        // Yii::$app->MP->Approval($this->tableName, 'add', '')

        return true;
    }

    public function beforeDelete() {
        if (!parent::beforeDelete()) {
            return false;
        }

        $changes = [];

        //get list of attributes
        $attrib = $this->activeAttributes();

        for ($i = 0; $i < count($attrib); $i++) {
            array_push($changes, array($attrib[$i], $this->{$attrib[$i]}));
        }
        //log activity to updatestatus table
        $log = new Updatestatus();
        $log->usern = $this->icno;
        $log->COTableName = $this->tableName();
        $log->COActivity = 2;
        $log->COUpadteDate = date('Y-m-d H:i:s');
        $log->COUpdateIP = Yii::$app->request->getRemoteIP();
        $log->COUpdateComp = Yii::$app->request->getRemoteIP();
        $log->COUpdateCompUser = Yii::$app->user->getId();
        $log->COUpdateSQL = serialize($changes);
        $log->save(false);
        $stat = Tblstat::find()->where(['ICNO' => $this->icno, 'table' => $this->tableName(), 'idval' => $this->id])->one();
        if ($stat == null)
            return true;

        $stat->delete();

        return true;
    }

    public function afterDelete() {

        //--biodata last update--//
        Yii::$app->MP->BiodataLastUpdate($this->icno);

        parent::afterDelete();
    }

}
