<?php

namespace App\Actions\Contact;

use App\Repositories\ContactRepositoryInterface;
use App\Models\Contact;

class CreateContact
{
    public function __construct(private ContactRepositoryInterface $repository) {}

    public function execute(array $data): Contact
    {
        $data['phone'] = preg_replace('/\D/', '', $data['phone']);
        return $this->repository->create($data);
    }
} 