<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    /**
     * Logs the creation of a new model record.
     * @param Model $model The newly created model instance.
     * @param string $action The custom action name.
     */
    protected function logCreation(Model $model, string $action = 'created')
    {
        // For creation, the new values are the model's attributes.
        $this->createLogEntry($model, $action, null, $model->toArray());
    }

    /**
     * Logs the update of an existing model record.
     * @param Model $model The updated model instance.
     * @param array $oldValues The data captured before the save operation.
     * @param string $action The custom action name.
     */
    protected function logUpdate(Model $model, array $oldValues, string $action = 'updated')
    {
        // Get only the fields that were actually modified by Eloquent's save() operation
        $changedValues = $model->getChanges();

        // Exclude system timestamps from the list of changes being logged
        unset($changedValues['updated_at']);

        // Only log if meaningful changes occurred
        if (!empty($changedValues)) {
            $this->createLogEntry($model, $action, $oldValues, $changedValues);
        }
    }

    /**
     * Logs the deletion of a model record.
     * NOTE: This should be called BEFORE the model is deleted.
     * @param Model $model The model instance about to be deleted.
     */
    protected function logDeletion(Model $model)
    {
        // For deletion, we only log the data that is about to be lost (old_values).
        $this->createLogEntry($model, 'deleted', $model->toArray(), null);
    }
    
    /**
     * Logs a custom, non-CRUD action (e.g., 'processed_charge' or 'csv_encoded').
     * @param Model $model The primary entity affected (e.g., the Charge model).
     * @param string $action The custom action name.
     * @param array $details Any relevant details to store in new_values.
     */
    protected function logCustomAction(Model $model, string $action, array $details = [])
    {
        $this->createLogEntry($model, $action, null, $details);
    }


    /**
     * Core function to create the AuditLog entry.
     */
    private function createLogEntry(Model $model, string $action, ?array $oldValues, ?array $newValues)
    {
        // Basic check to ensure a user is authenticated before logging
        if (!Auth::check()) {
             // You might log a critical error here if an action is performed unauthenticated
             return;
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'auditable_type' => get_class($model),
            'auditable_id' => $model->id,
            'action' => $action,
            'old_values' => $oldValues,
            'new_values' => $newValues,
        ]);
    }
}
