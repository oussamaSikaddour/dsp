<?php

namespace App\Traits\Core\Common;

use App\Models\AuditLog;


trait Auditable
{
    // protected static function bootAuditable()
    // {
    //     static::created(function ($model) {
    //         $model->audit(AuditAction::CREATE->value);
    //     });

    //     static::updated(function ($model) {
    //         if (empty($model->getChanges())) return;

    //         $model->audit(AuditAction::UPDATE->value);
    //     });

    //     static::deleted(function ($model) {
    //         $model->audit(AuditAction::DELETE->value);
    //     });
    // }

    /*
    |--------------------------------------------------------------------------
    | Core audit method
    |--------------------------------------------------------------------------
    */

    public function audit(string $action, ?string $description = null): void
    {
        try {
            AuditLog::create([
                'user_id' => auth()->id(),

                'entitiable_type' => get_class($this),
                'entitiable_id'   => $this->id,

                'action' => $action,
                'description' => $description ?? $action,
            ]);
        } catch (\Throwable $e) {
            report($e);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Relationship
    |--------------------------------------------------------------------------
    */

    public function auditLogs()
    {
        return $this->morphMany(AuditLog::class, 'entitiable')->latest();
    }
}
