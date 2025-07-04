<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\ContactDeletedMail;
use Illuminate\Support\Facades\Mail;

class TestEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email sending functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        // Criar um contato de teste
        $contact = (object) [
            'name' => 'Test Contact',
            'email' => $email,
            'phone' => '(11) 99999-9999'
        ];
        
        try {
            Mail::to($email)->send(new ContactDeletedMail($contact));
            $this->info('Email sent successfully!');
            $this->info('Check storage/logs/laravel.log for email content.');
        } catch (\Exception $e) {
            $this->error('Failed to send email: ' . $e->getMessage());
        }
    }
}
