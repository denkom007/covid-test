<?php

namespace app\modules\api\forms;

use app\modules\api\models\Patient;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class PatientFilterForm extends Model
{
    /**
     * Типы специально не ставил, особенность поведения Model::load()
     * будет вызвано исключение раньше валидации.
     */
    public $name = null;
    public $phone = null;
    public $polyclinic_id = null;
    public $status_id = null;
    public $form_disease_id = null;
    public $treatment_id = null;
    public $page = null;
    
    public function rules(): array
    {
        return [
            [['name', 'phone'], 'string'],
            [['polyclinic_id', 'status_id', 'form_disease_id', 'treatment_id', 'page'], 'integer'],
        ];
    }
    
    public function formName(): string
    {
        return '';
    }
    
    /**
     * @throws InvalidConfigException
     */
    public function getDataProvider()
    {
        return Yii::createObject(
            [
                'class'      => ActiveDataProvider::class,
                'query'      => $this->getQuery(),
                'pagination' => [
                    'pageSize' => 100,
                    'page'     => (!empty($this->page) && ($this->page > 0)) ? $this->page - 1 : 0,
                ],
                'sort'       => [
                    'defaultOrder' => [
                        'id' => SORT_DESC,
                    ],
                ],
            ]
        );
    }
    
    private function getQuery(): ActiveQuery
    {
        return Patient::find()
            ->with(['status', 'polyclinic', 'treatment', 'formDisease', 'updatedBy'])
            ->andFilterWhere([
                                 'polyclinic_id'   => $this->polyclinic_id,
                                 'status_id'       => $this->status_id,
                                 'form_disease_id' => $this->form_disease_id,
                                 'treatment_id'    => $this->treatment_id,
                             ])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone]);
    }
}