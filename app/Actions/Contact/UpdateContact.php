<?php

namespace App\Actions\Contact;

use App\Repositories\ContactRepositoryInterface;
use App\Models\Contact;

class UpdateContact
{
    public function __construct(private ContactRepositoryInterface $repository) {}

    public function execute(int $id, array $data): Contact
    {
        $data['phone'] = preg_replace('/\D/', '', $data['phone']);
        return $this->repository->update($id, $data);
    }
} 