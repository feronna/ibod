<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "hronline.tblcutibelajar".
 *
 * @property int $id
 * @property string $icno
 * @property string $institution
 * @property string $CountryCd
 * @property int $HighestEduLevelCd
 * @property int $class_group_id
 * @property int $detail_id
 * @property int $mode_id
 * @property string $SponsorshipCd
 * @property string $start_study_date
 * @property string $end_study_date
 * @property string $registration_date
 * @property string $end_study_date_expected
 * @property int $status_id
 * @property string $entry_dt
 * @property string $update_dt
 */
class CutiBelajar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.tblcutibelajar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['HighestEduLevelCd', 'class_group_id', 'detail_id', 'mode_id', 'status_id'], 'integer'],
            [['start_study_date', 'end_study_date', 'registration_date', 'end_study_date_expected', 'entry_dt', 'update_dt'], 'safe'],
            [['icno'], 'string', 'max' => 15],
            [['institution'], 'string', 'max' => 255],
            [['CountryCd'], 'string', 'max' => 3],
            [['SponsorshipCd'], 'string', 'max' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'institution' => 'Institution',
            'CountryCd' => 'Country Cd',
            'HighestEduLevelCd' => 'Highest Edu Level Cd',
            'class_group_id' => 'Class Group ID',
            'detail_id' => 'Detail ID',
            'mode_id' => 'Mode ID',
            'SponsorshipCd' => 'Sponsorship Cd',
            'start_study_date' => 'Start Study Date',
            'end_study_date' => 'End Study Date',
            'registration_date' => 'Registration Date',
            'end_study_date_expected' => 'End Study Date Expected',
            'status_id' => 'Status ID',
            'entry_dt' => 'Entry Dt',
            'update_dt' => 'Update Dt',
        ];
    }
}
