<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Pegawai;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


use function Laravel\Prompts\password;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        User::factory()->create([
            'name' => 'ipang',
            'email' => 'ipangyuwono70@gmail.com',
            'password'=> Hash::make('ecalay')
        ]);
        
        Customer::insert([
        [
        'nama' => 'ipang yuwono','kelas' => 'SA 02',
        'password' => '3115','departemen' => 'Plan and Budgeting',
        'created_at' => now(), 'updated_at' => now(),
        ],  
        
        [
        'nama' => 'Zahra Yogiasih', 'kelas' => 'SA 03',
        'password' => '1234','departemen' => 'Biology',
        'created_at' => now(),'updated_at' => now(),
        ],
]);

        Pegawai::create([
            'id_pegawai' => 'MIS01',
            'jabatan' => 'foreman',
            'email' => 'mis@gmail.com',
            'password' => '123456'
        ]);

        

    }
}
