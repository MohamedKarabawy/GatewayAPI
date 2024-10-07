<?php

namespace App\Policies;

use App\Models\Trainee;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Traits\CheckPermission;

class TraineePolicy
{
    use CheckPermission;

    public function __construct()
    {
        $this->permissions = ['create' => ['create-trainees'],
        'view-follow-up' => ['create-trainees', 'update-trainees', 'update-own-trainees'],
        'view-trainers' => ['create-trainees', 'update-trainees', 'update-own-trainees'],
        'view' => ['view-trainees', 'view-own-trainees'],
        'update' => ['update-trainees', 'update-own-trainees'],
        'delete' => ['delete-trainees', 'delete-own-trainees']];

        $this->permission_collection['waitlist'] = 'waitlist';
        $this->permission_collection['pendinglist'] = 'pendinglist';
        $this->permission_collection['holdlist'] = 'holdlist';
        $this->permission_collection['refundlist'] = 'refundlist';
        $this->permission_collection['blacklist'] = 'blacklist';
        $this->permission_collection['list']['waitlist'] = 'Wait List';
        $this->permission_collection['list']['pendinglist'] = 'Pending List';
        $this->permission_collection['list']['holdlist'] = 'Hold List';
        $this->permission_collection['list']['refundlist'] = 'Refund List';
        $this->permission_collection['list']['blacklist'] = 'Blacklist';
    }

    public function viewTrainers(?User $current_user, ?Trainee $trainee)
    {
        return $this->CheckPermission($current_user, $this->permissions['view-trainers'], $this->permission_collection['waitlist']);
    }

    public function viewTrainee(?User $current_user, ?Trainee $trainee)
    {
        return $this->CheckPermission($current_user, $this->permissions['view'], $this->permission_collection['waitlist'], $trainee->user_id) && $trainee->list->list_title === $this->permission_collection['list']['waitlist'];
    }

    public function createTrainee(User $current_user, Trainee $trainee)
    {
        return $this->CheckPermission($current_user, $this->permissions['create'], $this->permission_collection['waitlist']);
    }

    public function updateTrainee(?User $current_user, ?Trainee $trainee)
    {
        return $this->CheckPermission($current_user, $this->permissions['update'], $this->permission_collection['waitlist'], $trainee->user_id) && $trainee->list->list_title === $this->permission_collection['list']['waitlist'];
    }

    public function deleteTrainee(?User $current_user, ?Trainee $trainee)
    {
        return $this->CheckPermission($current_user, $this->permissions['delete'], $this->permission_collection['waitlist'], $trainee->user_id) && $trainee->list->list_title === $this->permission_collection['list']['waitlist'];
    }

    public function viewFollowUp(?User $current_user, ?Trainee $trainee)
    {
        return $this->CheckPermission($current_user, $this->permissions['view-follow-up'], $this->permission_collection['pendinglist']);
    }

    public function viewPendingTrainers(?User $current_user, ?Trainee $trainee)
    {
        return $this->CheckPermission($current_user, $this->permissions['view-trainers'], $this->permission_collection['pendinglist']);
    }

    public function viewPendingTrainee(?User $current_user, ?Trainee $trainee)
    {
        return $this->CheckPermission($current_user, $this->permissions['view'], $this->permission_collection['pendinglist'], $trainee->user_id) && $trainee->list->list_title === $this->permission_collection['list']['pendinglist'];
    }

    public function createPendingTrainee(?User $current_user, ?Trainee $trainee)
    {
        return $this->CheckPermission($current_user, $this->permissions['create'], $this->permission_collection['pendinglist']);
    }

    public function updatePendingTrainee(?User $current_user, ?Trainee $trainee)
    {
        return $this->CheckPermission($current_user, $this->permissions['update'], $this->permission_collection['pendinglist'], $trainee->user_id) && $trainee->list->list_title === $this->permission_collection['list']['pendinglist'];
    }

    public function deletePendingTrainee(?User $current_user, ?Trainee $trainee)
    {
        return $this->CheckPermission($current_user, $this->permissions['delete'], $this->permission_collection['pendinglist'], $trainee->user_id) && $trainee->list->list_title === $this->permission_collection['list']['pendinglist'];
    }

    public function viewHoldTrainers(?User $current_user, ?Trainee $trainee)
    {
        return $this->CheckPermission($current_user, $this->permissions['view-trainers'], $this->permission_collection['holdlist']);
    }

    public function viewHoldTrainee(?User $current_user, ?Trainee $trainee)
    {
        return $this->CheckPermission($current_user, $this->permissions['view'], $this->permission_collection['holdlist'], $trainee->user_id) && $trainee->list->list_title === $this->permission_collection['list']['holdlist'];
    }

    public function updateHoldTrainee(?User $current_user, ?Trainee $trainee)
    {
        return $this->CheckPermission($current_user, $this->permissions['update'], $this->permission_collection['holdlist'], $trainee->user_id) && $trainee->list->list_title === $this->permission_collection['list']['holdlist'];
    }

    public function deleteHoldTrainee(?User $current_user, ?Trainee $trainee)
    {
        return $this->CheckPermission($current_user, $this->permissions['delete'], $this->permission_collection['holdlist'], $trainee->user_id) && $trainee->list->list_title === $this->permission_collection['list']['holdlist'];
    }

    public function viewRefundTrainers(?User $current_user, ?Trainee $trainee)
    {
        return $this->CheckPermission($current_user, $this->permissions['view-trainers'], $this->permission_collection['refundlist']);
    }

    public function viewRefundTrainee(?User $current_user, ?Trainee $trainee)
    {
        return $this->CheckPermission($current_user, $this->permissions['view'], $this->permission_collection['refundlist'], $trainee->user_id) && $trainee->list->list_title === $this->permission_collection['list']['refundlist'];
    }

    public function updateRefundTrainee(?User $current_user, ?Trainee $trainee)
    {
        return $this->CheckPermission($current_user, $this->permissions['update'], $this->permission_collection['refundlist'], $trainee->user_id) && $trainee->list->list_title === $this->permission_collection['list']['refundlist'];
    }

    public function deleteRefundTrainee(?User $current_user, ?Trainee $trainee)
    {
        return $this->CheckPermission($current_user, $this->permissions['delete'], $this->permission_collection['refundlist'], $trainee->user_id) && $trainee->list->list_title === $this->permission_collection['list']['refundlist'];
    }

    public function viewBlackTrainers(?User $current_user, ?Trainee $trainee)
    {
        return $this->CheckPermission($current_user, $this->permissions['view-trainers'], $this->permission_collection['pendinglist']);
    }

    public function viewBlackTrainee(?User $current_user, ?Trainee $trainee)
    {
        return $this->CheckPermission($current_user, $this->permissions['view'], $this->permission_collection['blacklist'], $trainee->user_id) && $trainee->list->list_title === $this->permission_collection['list']['blacklist'];
    }

    public function updateBlackTrainee(?User $current_user, ?Trainee $trainee)
    {
        return $this->CheckPermission($current_user, $this->permissions['update'], $this->permission_collection['blacklist'], $trainee->user_id) && $trainee->list->list_title === $this->permission_collection['list']['blacklist'];
    }

    public function deleteBlackTrainee(?User $current_user, ?Trainee $trainee)
    {
        return $this->CheckPermission($current_user, $this->permissions['delete'], $this->permission_collection['blacklist'], $trainee->user_id) && $trainee->list->list_title === $this->permission_collection['list']['blacklist'];
    }
}