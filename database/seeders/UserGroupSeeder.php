<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::query();
        Group::all()->each(function (Group $group) use ($users) {
            $userIds = $users->pluck('id')->toArray();
            $arrayRand = array_rand($userIds);
            $userId = $userIds[$arrayRand];
            $sliceUsers = array_splice($userIds, $userId, 10);
            $group->userGroups()
                ->attach($sliceUsers, ['accepted_invite' => true]);
        });
    }
}
