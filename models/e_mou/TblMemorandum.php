<?php

namespace app\models\e_mou;

use app\models\hronline\Department;
use app\models\hronline\Country;
use Yii;

/**
 * This is the model class for table "emou.t_emou01_memorandum".
 *
 * @property int $memorandum_id
 * @property int $id_dept
 * @property string $external_parties
 * @property string $code_country
 * @property string $code_country2
 * @property string $signature_date
 * @property string $expiration_date
 * @property int $id_memorandum_type
 * @property int $id_approver_committee
 * @property int $id_status
 * @property string $status_date
 * @property string $status_comment
 * @property string $submit_date
 * @property int $id_verify
 * @property string $verify_date
 * @property string $verify_comment
 * @property int $id_review
 * @property string $review_date
 * @property string $review_comment
 * @property int $id_approval
 * @property string $approval_date
 * @property string $approval_comment
 * @property int $id_second_approval
 * @property string $second_approval_date
 * @property string $second_approval_comment
 * @property int $id_seal
 * @property string $seal_date
 * @property string $seal_comment
 * @property int $id_verify_update
 * @property string $verify_update_date
 * @property string $verify_update_comment
 * @property string $jfpiu_files
 * @property string $jfpiu_files2
 * @property string $bpt_files
 * @property string $bpt_files2
 * @property string $last_update
 * @property string $user_update
 */
class TblMemorandum extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emou.t_emou01_memorandum';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_dept', 'external_parties', 'code_country', 'signature_date', 'expiration_date', 'id_memorandum_type', 'jfpiu_files'], 'required'],
            [['id_dept', 'id_memorandum_type', 'id_approver_committee', 'id_status', 'id_verify', 'id_review', 'id_approval', 'id_second_approval', 'id_seal', 'id_verify_update'], 'integer'],
            [['signature_date', 'expiration_date', 'status_date', 'submit_date', 'verify_date', 'review_date', 'approval_date', 'second_approval_date', 'seal_date', 'verify_update_date', 'last_update'], 'safe'],
            [['status_comment', 'verify_comment', 'review_comment', 'approval_comment', 'second_approval_comment', 'seal_comment', 'verify_update_comment'], 'string'],
            [['external_parties'], 'string', 'max' => 255],
            [['code_country', 'code_country2'], 'string', 'max' => 3],
            [['jfpiu_files', 'jfpiu_files2', 'bpt_files', 'bpt_files2'], 'string', 'max' => 300],
            [['user_update'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'memorandum_id' => 'Memorandum ID',
            'id_dept' => 'Id Dept',
            'external_parties' => 'External Parties',
            'code_country' => 'Code Country',
            'code_country2' => 'Code Country2',
            'signature_date' => 'Signature Date',
            'expiration_date' => 'Expiration Date',
            'id_memorandum_type' => 'Id Memorandum Type',
            'id_approver_committee' => 'Id Approver Committee',
            'id_status' => 'Id Status',
            'status_date' => 'Status Date',
            'status_comment' => 'Status Comment',
            'submit_date' => 'Submit Date',
            'id_verify' => 'Id Verify',
            'verify_date' => 'Verify Date',
            'verify_comment' => 'Verify Comment',
            'id_review' => 'Id Review',
            'review_date' => 'Review Date',
            'review_comment' => 'Review Comment',
            'id_approval' => 'Id Approval',
            'approval_date' => 'Approval Date',
            'approval_comment' => 'Approval Comment',
            'id_second_approval' => 'Id Second Approval',
            'second_approval_date' => 'Second Approval Date',
            'second_approval_comment' => 'Second Approval Comment',
            'id_seal' => 'Id Seal',
            'seal_date' => 'Seal Date',
            'seal_comment' => 'Seal Comment',
            'id_verify_update' => 'Id Verify Update',
            'verify_update_date' => 'Verify Update Date',
            'verify_update_comment' => 'Verify Update Comment',
            'jfpiu_files' => 'Jfpiu Files',
            'jfpiu_files2' => 'Jfpiu Files2',
            'bpt_files' => 'Bpt Files',
            'bpt_files2' => 'Bpt Files2',
            'last_update' => 'Last Update',
            'user_update' => 'User Update',
        ];
    }

    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'id_dept']);
    }

    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['CountryCd' => 'code_country']);
    }

    public function getEmouType()
    {
        return $this->hasOne(RefMemorandumType::className(), ['memorandum_type_id' => 'id_memorandum_type']);
    }

    public function getEmouStatus()
    {
        return $this->hasOne(RefMemorandumStatus::className(), ['status_id' => 'id_status']);
    }

    public function getEmouApprover()
    {
        return $this->hasOne(RefMemorandumApprover::className(), ['approver_committee_id' => 'id_approver_committee']);
    }

    public function getEmouField()
    {
        return $this->hasMany(TblMemorandumField::className(), ['id_memorandum' => 'memorandum_id'])->orderBy(['order_no' => SORT_ASC]);
    }

    public function getEmouKpi()
    {
        return $this->hasMany(TblMemorandumKpi::className(), ['id_memorandum' => 'memorandum_id'])->orderBy(['order_no' => SORT_ASC]);
    }

    public function getEmouActivity()
    {
        return $this->hasMany(TblMemorandumActivity::className(), ['id_memorandum' => 'memorandum_id'])->orderBy(['order_no' => SORT_ASC]);
    }

    public function getEmouVerify()
    {
        return $this->hasOne(TblMemorandumVerifyHistory::className(), ['id_memorandum' => 'memorandum_id']);
    }

    public function getEmouApproval()
    {
        return $this->hasOne(RefApproval::className(), ['approval_id' => 'id_approval']);
    }

    public function getEmouSecApproval()
    {
        return $this->hasOne(RefSecondApproval::className(), ['second_approval_id' => 'id_second_approval']);
    }

    public function getReview()
    {
        return $this->hasOne(RefReviewHistory::className(), ['review_id' => 'id_review']);
    }
}
