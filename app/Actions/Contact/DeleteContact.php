<?php

namespace App\Actions\Contact;

use App\Repositories\ContactRepositoryInterface;
use App\Mail\ContactDeletedMail;
use Illuminate\Support\Facades\Mail;

class DeleteContact
{
    public function __construct(private ContactRepositoryInterface $repository) {}

    public function execute(int $id): void
    {
        // Buscar o contato antes de deletar
        $contact = $this->repository->find($id);
        
        if ($contact) {
            // Enviar e-mail antes de deletar
            try {
                Mail::to($contact->email)->send(new ContactDeletedMail($contact));
            } catch (\Exception $e) {
                // Log do erro, mas continua com a exclusão
                \Log::error('Erro ao enviar e-mail de exclusão: ' . $e->getMessage());
            }
        }
        
        // Deletar o contato
        $this->repository->delete($id);
    }
} 