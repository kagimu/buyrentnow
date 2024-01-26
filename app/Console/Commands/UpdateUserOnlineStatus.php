<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UpdateUserOnlineStatus extends Command
{
    protected $signature = 'update:user-status';

    protected $description = 'Update user status to offline at 12 AM every day';

    public function handle()
    {
        // Get users who were online before today
        $usersToUpdate = User::where('online', true)
            ->where('last_activity', '<', now()->startOfDay())
            ->get();

        // Update the status to offline
        $usersToUpdate->each(function ($user) {
            $user->online = false;
            $user->save();
        });

        $this->info('User status updated successfully.');
    }
}
