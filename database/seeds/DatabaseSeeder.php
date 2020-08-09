<?php

use App\User;
use App\Channel;
use App\Subscription;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $user1 = factory(User::class)->create([
            'email' => 'john@example.com'
        ]);

        $user2 = factory(User::class)->create([
            'email' => 'jane@example.com'
        ]);

        $channel1 = factory(Channel::class)->create([
            'user_id' => $user2->id,
        ]);

        $channel2 = factory(Channel::class)->create([
            'user_id' => $user1->id
        ]);

        $channel1->subscriptions()->create([
            'user_id' => $user1->id
        ]);

        $channel2->subscriptions()->create([
            'user_id' => $user2->id
        ]);

        factory(Subscription::class, 10)->create([
            'channel_id' => $channel1->id
        ]);

        factory(Subscription::class, 10)->create([
            'channel_id' => $channel2->id
        ]);
    }
}
