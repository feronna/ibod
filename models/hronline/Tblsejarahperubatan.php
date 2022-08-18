<?php

namespace app\models\hronline;

use Yii;
use app\models\hronline\JenisPenyakit;
//audit trail
use app\models\hronline\Updatestatus;
use app\models\hronline\Tblstat;

/**
 * This is the model class for table "hronline.tblprmedhis".
 *
 * @property string $ICNO
 * @property string $IllnessCd
 * @property string $IllnessOther
 * @property string $Year
 * @property string $MedTreatment
 * @property string $TreatmentStartDt
 * @property string $TreatmentEndDt
 * @property int $id
 */
class Tblsejarahperubatan extends \yii\db\ActiveRecord
{
  // add the function below:
  public static function getDb()
  {
    return Yii::$app->get('db2'); // second database
  }

  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'hronline.tblprmedhis';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['ICNO', 'IllnessCd', 'Year', 'MedTreatment'], 'required', 'message' => 'Ruang ini adalah mandatori'],
      [['TreatmentStartDt', 'TreatmentEndDt'], 'safe'],
      [['ICNO'], 'string', 'max' => 12],
      [['IllnessCd', 'Year'], 'string', 'max' => 4],
      [['IllnessOther'], 'string', 'max' => 200],
      [['MedTreatment'], 'string', 'max' => 60],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'ICNO' => 'Icno',
      'IllnessCd' => 'Illness Cd',
      'IllnessOther' => 'Illness Other',
      'Year' => 'Year',
      'MedTreatment' => 'Med Treatment',
      'TreatmentStartDt' => 'Treatment Start Dt',
      'TreatmentEndDt' => 'Treatment End Dt',
      'id' => 'ID',
    ];
  }

  public function getJenisPenyakit()
  {
    return $this->hasOne(JenisPenyakit::className(), ['IllnessCd' => 'IllnessCd']);
  }

  public function getJenpenyakit()
  {
    if ($this->jenisPenyakit) {
      return $this->jenisPenyakit->Illness;
    }
    return '-';
  }

  public function getTreatmentStartDt()
  {
    if (!empty($this->TreatmentStartDt)) {
      return Yii::$app->MP->Tarikh($this->TreatmentStartDt);
    }
    return '-';
  }
  public function getTreatmentEndDt()
  {
    if (!empty($this->TreatmentEndDt)) {
      return Yii::$app->MP->Tarikh($this->TreatmentEndDt);
    }
    return '-';
  }


  //log for Create, update or delete data.
  public function beforeSave($insert)
  {
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
      $log->usern = $tempObj->ICNO; //Yii::$app->user->getId();
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
      $stat = Tblstat::find()->where(['ICNO' => $this->ICNO, 'table' => $this->tableName(), 'idval' => $this->id])->one();
      if ($stat == null) {
        $stat = new Tblstat();
        $stat->ICNO = $this->ICNO;
        $stat->table = $this->tableName();
        $stat->idval = $this->id;
      }
      $stat->status = 1;
      $stat->date_submit = date('Y-m-d H:i:s');
      $stat->save(false);

      Yii::$app->MP->BiodataLastUpdate($this->ICNO);
    }

    return true;
  }

  public function afterSave($insert, $changedAttributes)
  {
    parent::afterSave($insert, $changedAttributes);

    if ($insert) {
      //save to tbl_stat
      $stat = new Tblstat();
      $stat->ICNO = $this->ICNO;
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
      $log->usern = $this->ICNO; //Yii::$app->user->getId();
      $log->COTableName = $this->tableName();
      $log->COActivity = $activity;
      $log->COUpadteDate = date('Y-m-d H:i:s');
      $log->COUpdateIP = Yii::$app->request->getRemoteIP();
      $log->COUpdateComp = Yii::$app->request->getRemoteIP();
      $log->COUpdateCompUser = Yii::$app->user->getId();
      $log->COUpdateSQL = serialize($changes);
      $log->idval = $this->id;
      $log->save(false);

      Yii::$app->MP->BiodataLastUpdate($this->ICNO);
    }
    return true;
  }

  public function beforeDelete()
  {
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
    $log->usern = $this->ICNO;
    $log->COTableName = $this->tableName();
    $log->COActivity = 2;
    $log->COUpadteDate = date('Y-m-d H:i:s');
    $log->COUpdateIP = Yii::$app->request->getRemoteIP();
    $log->COUpdateComp = Yii::$app->request->getRemoteIP();
    $log->COUpdateCompUser = Yii::$app->user->getId();
    $log->COUpdateSQL = serialize($changes);
    $log->save(false);
    $stat = Tblstat::find()->where(['ICNO' => $this->ICNO, 'table' => $this->tableName(), 'idval' => $this->id])->one();
    if ($stat == null)
      return true;

    $stat->delete();

    return true;
  }

  public function afterDelete(){

    //--biodata last update--//
    Yii::$app->MP->BiodataLastUpdate($this->ICNO);

    parent::afterDelete();
  }
  
}
