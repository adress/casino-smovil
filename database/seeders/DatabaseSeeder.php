<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Src\Roulette\Transactions\Domain\TransactionService;
use Src\Roulette\Transactions\Infrastructure\Repositories\Eloquent\TransactionRepository;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    // \App\Models\User::factory(10)->create();

    \App\Models\User::factory()->create([
      'name' => 'Admin User',
      'email' => env('ADMIN_EMAIL')
    ]);

    $transaction = new TransactionService(new TransactionRepository(new Transaction()));
    $transaction->transaction(
      userId: 1,
      transactionType: 1,
      amount: 10000,
    );
  }
}
