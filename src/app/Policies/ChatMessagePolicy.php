<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ChatMessage;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChatMessagePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, ChatMessage $message)
    {
        return $user->id === $message->user_id;
    }

    public function delete(User $user, ChatMessage $message)
    {
        return $user->id === $message->user_id;
    }
}
