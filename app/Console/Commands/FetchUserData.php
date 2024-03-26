<?php

namespace App\Console\Commands;

use App\Models\ApiUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use League\Csv\Writer;

class FetchUserData extends Command
{
    protected $signature = 'fetch:user-data';
    protected $description = 'Fetch user data from API and save it to database';

    public function handle()
    {
        $url = 'https://61f07509732d93001778ea7d.mockapi.io/api/v1/user/users';
        
        $response = Http::get($url);

        if ($response->successful()) {
            $users = $response->json();
            foreach ($users as $userData) {
                ApiUser::create(
                    $userData
                );
            }

            $csvFilePath = storage_path('app/users.csv');

            if (file_exists($csvFilePath)) {
                $csv = Writer::createFromPath($csvFilePath, 'a+');
            } else {
                $csv = Writer::createFromPath($csvFilePath, 'w+');
                $csv->insertOne(array_keys(array_reverse($users[0]))); 
            }

            foreach ($users as $userData) {
                $csv->insertOne(array_reverse($userData));
            }

            $this->info('User data fetched and saved successfully.');
        } else {
            $this->error('Failed to fetch user data.');
        }
    }
}
