<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Determine whether the user can perform management actions on the task.
     */
    public function manage(User $user, Task $task): bool
    {
        return $user->is($task->user);
    }
}
