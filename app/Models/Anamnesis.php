<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anamnesis extends Model
{
    use HasFactory;
    protected $table = 'employee_anamnesis';
    protected $fillable = [
        'onset',
        'frequency',
        'complaint_development',
        'things_that_trigger_complaints',
        'things_to_reduce_complaints',
        'another_complaint',
        'common_symptoms',
        'skin_symptoms',
        'sensory_symptoms',
        'respiratory_symptoms',
        'cardiovascular_symptoms',
        'digestive_symptoms',
        'nervous_symptoms',
        'psychological_symptoms',
        'endocrine_symptoms',
        'musculoskeletal_symptoms',
        'past_medical_history',
        'when_diagnosed',
        'where_was_diagnosed',
        'by_whom_was_diagnosed',
        'how_is_the_treatment',
        'allergy_history',
        'drugs_that_have_been_taken',
        'type_of_medicine_and_for_how_long',
        'habit_history',
        'family_history',
        'employee_mcu_id',
        'created_at',
        'updated_at',
      ];
}
