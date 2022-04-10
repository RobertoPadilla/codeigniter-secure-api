<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class UserSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('user')->insert($this->generateAdmin());
        
		for ($i = 0; $i < 3; $i++) {
            $this->db->table('user')->insert($this->generateUser());
        }
    }


	private function generateAdmin(): array
    {
        return [
            'name' => 'Roberto Padilla',
            'email' => 'admin@example.com',
            'password' => password_hash('12345678', PASSWORD_BCRYPT),
            'is_admin' => true,
        ];
    } 

	private function generateUser(): array
    {
        $faker = Factory::create();
        return [
            'name' => $faker->name(),
            'email' => $faker->email,
            'password' => password_hash('abcdefghijk', PASSWORD_BCRYPT),
            'is_admin' => false,
        ];
    } 
}
