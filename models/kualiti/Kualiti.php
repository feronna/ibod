<?php

namespace app\models\kualiti;

use Yii;
use app\models\hronline\Department;
use app\models\hronline\Tblprcobiodata;
use yii\helpers\Html;

/**
 * This is the model class for table "utilities.kualiti_main".
 *
 * @property int $msiso_id
 * @property int $kategori_id
 * @property string $no_prosedur
 * @property string $tajuk_prosedur
 * @property string $nama_fail
 * @property string $susunan
 * @property int $jfpib
 * @property string $insert_date
 * @property string $update_date
 * @property string $update_id
 */
class Kualiti extends \yii\db\ActiveRecord
{

    public $tempFile;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.kualiti_main';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kategori_id', 'jfpib'], 'integer'],
            [['susunan'], 'number','message'=>'Ruangan ini wajib diisi!'],
            [['susunan'], 'required','message'=>'Ruangan ini wajib diisi!'],
            [['insert_date', 'update_date'], 'safe'],
            [['no_prosedur'], 'string', 'max' => 10,],
            [['no_prosedur'], 'required','message'=>'Ruangan ini wajib diisi!'],
            [['tajuk_prosedur', 'nama_fail'], 'string', 'max' => 100],
            [['tajuk_prosedur'], 'required','message'=>'Ruangan ini wajib diisi!'],
            [['update_id'], 'string', 'max' => 12],
            [['file','tempFile'],'safe'],
            [['file'],'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'msiso_id' => 'ID',
            'kategori_id' => 'Kategori ID',
            'no_prosedur' => 'No Prosedur',
            'tajuk_prosedur' => 'Tajuk Prosedur',
            'nama_fail' => 'Nama Fail',
            'susunan' => 'Susunan',
            'jfpib' => 'JAFPIB',
            'insert_date' => 'Direkodkan Pada',
            'update_date' => 'Kemaskini Akhir',
            'update_id' => 'Dikemaskini Oleh',
        ];
    }

    public function getKategori() {
        if ($this->kategori_id == '1') {
            return '<span class="label label-info">MANUAL KUALITI</span>';
        }

        if ($this->kategori_id == '2') {
            return '<span class="label label-primary">PROSEDUR KHUSUS</span>';
        }
        if ($this->kategori_id == '3') {
            return '<span class="label label-success">PROSEDUR UMUM</span>';
        }
        if ($this->kategori_id == '4') {
            return '<span class="label label-warning">DOKUMEN RUJUKAN</span>';
        }
        if ($this->kategori_id == '5') {
            return '<span class="label label-default">BORANG</span>';
        }
    }

    public function getNama()
    {
        return $this->hasOne(Kategori::className(),['kategori_id'=>'kategori_id']);
    }

    public function getDepartment(){
        return $this->hasOne(Department::className(), ['id'=> 'jfpib']);
    } 

    public function getUpdater()
    {
        return $this->hasOne(Tblprcobiodata::className(),['ICNO'=>'update_id']);
    }

    public function getDisplayLink() {
        if(!empty($this->file)){
        return html::a(Yii::$app->FileManager->NameFile($this->file), Yii::$app->FileManager->DisplayFile($this->file), ['target'=>'_blank']);
        }
        return 'Sila muatnaik dokumen lampiran!';
    }

}
