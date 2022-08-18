<?php

namespace app\models\dkums;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "utilities.dkums_questions".
 *
 * @property int $id
 * @property string $bhgn
 * @property int $number
 * @property string $malay
 * @property string $english
 */
class Questions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.dkums_questions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bhgn', 'number', 'malay', 'english'], 'required'],
            [['number'], 'integer'],
            [['malay', 'english'], 'string'],
            [['bhgn'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bhgn' => 'Bhgn',
            'number' => 'Number',
            'malay' => 'Malay',
            'english' => 'English',
        ];
    }

    public static function getProvider($bhgn)
    {
        $provider = new ActiveDataProvider([
            'query' => self::find()->where(['bhgn' => $bhgn])->orderBy(['id' => SORT_ASC]),
            'pagination' => false,
        ]);

        return $provider;
    }

    public function getStatement()
    {

        return "<p><strong>$this->malay / <i style='color:green;'>$this->english</i></strong></p>";
    }

    public static function displayQuestion($code)
    {

        $bhgn = substr($code,0,1);
        $no = substr($code,1,2);

        $model = Questions::find()->where(['bhgn'=>$bhgn, 'number'=>$no])->one();

        return $model->malay . "<br><i>" . $model->english . '</i>';
    }

    public static function findQuestion($code = null)
    {

        $bhgn = substr($code,0,1);
        $no = substr($code,1,2);

        $model = Questions::find()->select(['bhgn' => 'CONCAT(bhgn,number)', 'malay' => 'malay'])->where([])->all();

     
        $data = ArrayHelper::map($model,'bhgn','malay');

        return $data;
    }
}
