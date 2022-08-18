<?php
namespace app\models\ejobs;
use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile; 

class TblpImg extends ActiveRecord
{ 
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7'); // second database
    }
    public $image;
    
    public static function tableName()
    {
        return 'ejobs.tbl_file_pemohon';
    }
    
    public function rules()
    {
        return [
//            [['image'], 'required'],
            [['avatar', 'filename', 'image','ICNO'], 'safe'],
            [['image'], 'file', 'extensions'=>'jpg'],
        ];
    }
 
    public function getImageFile() 
    {
        Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/ejobs/gambar/'; 
        return isset($this->avatar) ? Yii::$app->params['uploadPath'] . $this->avatar : null;
    }
 
    public function getImageUrl() 
    { 
        Yii::$app->params['uploadUrl'] = '@web/uploads/ejobs/gambar/';
        // return a default image placeholder if your source avatar is not found
        $avatar = isset($this->avatar) ? $this->avatar : 'default_user.jpg';
        return Yii::$app->params['uploadUrl'] . $avatar;
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