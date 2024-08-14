<?php

namespace Database\Seeders;

use App\Enums\Action;
use App\Enums\Role;
use App\Models\About;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        About::factory()->create([
            'content' => '&lt;p&gt;&lt;strong&gt;INVETKER&lt;/strong&gt; is a beginner-friendly stock tracking platform with a user-friendly interface. Tracking your stocks is a breeze with INVETKER. Its clear charts make performance monitoring a snap. Plus, its real-time ranking system gives you key insights into your Rate of Return. Whether you&#039;re new to investing or just want a hassle-free way to manage your portfolio, INVETKER has got you covered. Gain confidence in the market with INVETKER&#039;s straightforward tools and clarity.For those who are new to investing, INVETKER is an ideal tool to build confidence in the market. Its straightforward tools and clear information make it simple to manage a portfolio without feeling overwhelmed. Whether you are just starting out or looking for a hassle-free way to keep track of your investments, INVETKER has you covered. The platforms user-friendly approach ensures that anyone can navigate the complexities of the stock market with ease, making investing a more approachable and rewarding experience. In addition to its user-friendly interface and insightful tools, INVETKER is committed to providing a seamless user experience. The platform is designed to be both functional and aesthetically pleasing, ensuring that users can easily find and use the features they need. With INVETKER, you can gain confidence in your investment choices and take control of your financial future. Whether you are tracking individual stocks or managing a diverse portfolio, INVETKERS comprehensive features and clarity make it the perfect companion for any investor.',
        ]);

        $user = User::factory()->create([
            'name' => 'Alexander, Johnson',
            'role' => Role::ADMIN->value,
            'email' => 'service@good-series.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678')
        ]);

        Transaction::factory(18)->create([
            'userId' => $user->id,
            'ticker' => 'TSLA',
            'action' => Action::BOUGHT->value,
        ]);

        Transaction::factory(12)->create([
            'userId' => $user->id,
            'ticker' => 'AAPL',
            'action' => Action::BOUGHT->value,
        ]);
    }
}
