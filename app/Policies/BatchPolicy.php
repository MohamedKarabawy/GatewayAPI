<?php

namespace App\Policies;

use App\Models\Batch;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Traits\CheckPermission;

class BatchPolicy
{
    use CheckPermission;
    
    public function __construct()
    {
        $this->permissions = ['activate-batch' => ['activate_batches', 'activate_own_batches'],
        'end-batch' => ['end_batches', 'end_own_batches'],
        'create-batches' => ['create_batches'],
        'view-batches' => ['view_batches', 'view_own_batches'],
        'update-batches' => ['update_batches', 'update_own_batches'],
        'delete-batches' => ['delete_batches', 'delete_own_batches'],
        'create-classes' => ['create_classes'],
        'view-classes' => ['view_classes', 'view_own_classes'],
        'update-classes' => ['update_classes', 'update_own_classes'],
        'delete-classes' => ['delete_classes', 'delete_own_classes'],
    ];

        $this->permission_collection = 'batches';
    }

    public function activateBatch(?User $current_user,?Batch $batch)
    {
        return $this->CheckPermission($current_user, $this->permissions['activate-batch'], $this->permission_collection, $batch->user_id);
    }

    public function endBatch(?User $current_user,?Batch $batch)
    {
        return $this->CheckPermission($current_user, $this->permissions['end-batch'], $this->permission_collection, $batch->user_id);
    }

    public function createBatches(?User $current_user,?Batch $batch)
    {
        return $this->CheckPermission($current_user, $this->permissions['create-batches'], $this->permission_collection);
    }

    public function viewBatches(?User $current_user,?Batch $batch)
    {
        return $this->CheckPermission($current_user, $this->permissions['view-batches'], $this->permission_collection, $batch->user_id);
    }

    public function updateBatches(?User $current_user,?Batch $batch)
    {
        return $this->CheckPermission($current_user, $this->permissions['update-batches'], $this->permission_collection, $batch->user_id);
    }

    public function deleteBatches(?User $current_user,?Batch $batch)
    {
        return $this->CheckPermission($current_user, $this->permissions['delete-batches'], $this->permission_collection, $batch->user_id);
    }
}