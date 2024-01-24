<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class UpdateUserOnlineStatus extends Command
{
    protected $signature = 'update:user-online-status';
    protected $description = 'Update user online status';

    public function handle()
    {
        // Get all users and set online status to false
        User::where('online', true)->update(['online' => false]);

        $this->info('User online status updated successfully.');
    }
}
