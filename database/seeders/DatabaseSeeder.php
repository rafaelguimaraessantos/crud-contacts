<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Contact;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Criar usuário de teste apenas se não existir
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        // Limpar contatos existentes e criar novos
        Contact::truncate();

        // Criar contatos de exemplo com dados mais realistas
        Contact::factory(20)->create([
            'name' => function () {
                return fake()->name();
            },
            'email' => function () {
                return fake()->unique()->safeEmail();
            },
            'phone' => function () {
                return fake()->numerify('(##) #####-####');
            }
        ]);

        // Criar alguns contatos específicos para demonstração
        Contact::create([
            'name' => 'João Silva',
            'email' => 'joao.silva@email.com',
            'phone' => '(11) 99999-8888'
        ]);

        Contact::create([
            'name' => 'Maria Santos',
            'email' => 'maria.santos@email.com',
            'phone' => '(21) 88888-7777'
        ]);

        Contact::create([
            'name' => 'Pedro Oliveira',
            'email' => 'pedro.oliveira@email.com',
            'phone' => '(31) 77777-6666'
        ]);
    }
}
