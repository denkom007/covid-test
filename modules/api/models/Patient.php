<?php

namespace app\modules\api\models;

use app\models\Patient as BasePatient;
use yii\behaviors\BlameableBehavior;
use yii\helpers\ArrayHelper;

class Patient extends BasePatient
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return ArrayHelper::merge([
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ], parent::behaviors());
    }
    
    /**
     * {@inheritdoc}
     */
    public function fields(): array
    {
        return [
            'id',
            'name',
            'birthday',
            'phone',
            'polyclinic'   => 'polyclinicFormatted',
            'status'       => 'statusFormatted',
            'treatment'    => 'treatmentFormatted',
            'form_disease' => 'formDiseaseFormatted',
            'updated',
            'diagnosis_date',
            'recovery_date',
        ];
    }
    
    public function getPolyclinicFormatted(): ?array
    {
        if (!empty($this->polyclinic)) {
            return [
                'id'   => $this->polyclinic->id ?? null,
                'name' => $this->polyclinic->name ?? null,
            ];
        }
        
        return null;
    }
    
    public function getTreatmentFormatted(): ?array
    {
        if (!empty($this->treatment)) {
            return [
                'id'   => $this->treatment->id ?? null,
                'name' => $this->treatment->name ?? null,
            ];
        }
        
        return null;
    }
    
    public function getFormDiseaseFormatted(): ?array
    {
        if (!empty($this->formDisease)) {
            return [
                'id'   => $this->formDisease->id ?? null,
                'name' => $this->formDisease->name ?? null,
            ];
        }
        
        return null;
    }
    
    public function getStatusFormatted(): ?array
    {
        if (!empty($this->status)) {
            return [
                'id'   => $this->status->id ?? null,
                'name' => $this->status->name ?? null,
            ];
        }
        
        return null;
    }
    
    public function formName(): string
    {
        return '';
    }
}
