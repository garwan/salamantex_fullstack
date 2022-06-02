<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EthereumWalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ethereum_wallets')
            ->insert(
                [
                    'address' => "0xc02aaa39b223fe8d0a0e5c4f27ead9083c7user1",
                    'balance' => '157.456132',
                    'user_id' => 1,
                ]
            );
        DB::table('ethereum_wallets')->insert(
            [
                'address' => "0xc02aaa39b223fe8d0a0e5c4f27ead9083c7user2",
                'balance' => '1254.456132',
                'user_id' => 2,
            ]
        );
        DB::table('ethereum_wallets')->insert(
            [
                'address' => "0xc02aaa39b223fe8d0a0e5c4f27ead9083c7user3",
                'balance' => '645175.456132',
                'user_id' => 3,
            ]
        );
    }
}
