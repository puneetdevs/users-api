<?php

namespace App\Console\Commands;

use App\Models\ApiUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use League\Csv\Writer;
use Illuminate\Support\Facades\File;

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
                ApiUser::updateOrCreate(
                    ['id' => $userData['id']],
                    $userData
                );
            }

            $date  = date('d_m_Y');
            $directory = storage_path("app/public/$date");
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0777, true, true);
            }

            $csvFilePath = storage_path("app/public/$date/users.csv");

            $csv = Writer::createFromPath($csvFilePath, 'w+');
            $csv->insertOne(array_keys(array_reverse($users[0]))); 

            foreach ($users as $userData) {
                $csv->insertOne(array_reverse($userData));
            }

            $this->info('User data fetched and saved successfully.');
        } else {
            $this->error('Failed to fetch user data.');
        }
    }
}
