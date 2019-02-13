<?php

namespace App\Models\Student\Traits;

/**
 * Class StudentAttribute.
 */
trait StudentAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/5.4/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn">
                '.$this->getEditButtonAttribute("edit-student", "admin.students.edit").'
                '.$this->getDeleteButtonAttribute("delete-student", "admin.students.destroy").'
                </div>';
    }
}
