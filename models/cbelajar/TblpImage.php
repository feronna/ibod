<?php
namespace app\models\cbelajar;
use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile; 
use yii\helpers\Html;

class TblpImage extends ActiveRecord
{ 
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    public $image;
    
    public static function tableName()
    {
        return 'hrd.cb_tbl_gambar';
    }
    
    public function rules()
    {
        return [
//            [['image'], 'required'],
            [['avatar', 'filename', 'image','ICNO'], 'safe'],
             [['iklan_id'], 'integer'],
            [['image'], 'file', 'extensions'=>'jpg'],
            [['created_dt'], 'safe'],

        ];
    }
 
    public function getImageFile() 
    {
         return 'https://mediahost.ums.edu.my/api/v1/viewFile/'.$this->filename;
    }
 
    public function getImageUrl() 
    { 
//        Yii::$app->params['uploadUrl'] =  Html::a(Yii::$app->FileManager->NameFile($this->filename), Yii::$app->FileManager->DisplayFile($this->filename)).'<br>';
      return 'https://mediahost.ums.edu.my/api/v1/viewFile/';

        // return a default image placeholder if your source avatar is not found
//        $avatar = isset($this->avatar) ? $this->avatar : 'default_user.jpg';
//        return Yii::$app->params['uploadUrl'] . $avatar;
    }
 
    public function uploadImage() { 
        $image = UploadedFile::getInstance($this, 'image');

        // if no image was uploaded abort the upload
        if (empty($image)) {
            return false;
        }
 
        $this->filename = $image->name;
        $ext = 'jpg';
 
        $this->avatar = Yii::$app->security->generateRandomString().".{$ext}";
 
        return $image;
    }
    
    
 
    public function deleteImage() {
        $file = $this->getImageFile();

        // check if file exists on server
        if (empty($file) || !file_exists($file)) {
            return false;
        }

        // check if uploaded file can be deleted on server
        if (!unlink($file)) {
            return false;
        }

        // if deletion successful, reset your file attributes
        $this->avatar = null;
        $this->filename = null;

        return true;
    }
}