<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BitcoinWalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bitcoin_wallets')
            ->insert(
                [
                    'address' => "1GjDMGrvdw15uTRbBQNA2ExCxL8Geuser1",
                    'balance' => '57.456132',
                    'user_id' => 1,
                ]
            );
        DB::table('bitcoin_wallets')->insert(
            [
                'address' => "1GjDMGrvdw15uTRbBQNA2ExCxL8Geuser2",
                'balance' => '124.456132',
                'user_id' => 2,
            ]
        );
        DB::table('bitcoin_wallets')->insert(
            [
                'address' => "1GjDMGrvdw15uTRbBQNA2ExCxL8Geuser3",
                'balance' => '675.456132',
                'user_id' => 3,
            ]
        );
    }
}
