<?php

namespace App\Models\Standard\Traits;

/**
 * Class StandardAttribute.
 */
trait StandardAttribute
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
                '.$this->getEditButtonAttribute("edit-standard", "admin.standards.edit").'
                '.$this->getDeleteButtonAttribute("delete-standard", "admin.standards.destroy").'
                </div>';
    }
}
