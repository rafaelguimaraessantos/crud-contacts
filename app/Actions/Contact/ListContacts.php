<?php

namespace App\Actions\Contact;

use App\Repositories\ContactRepositoryInterface;

class ListContacts
{
    public function __construct(private ContactRepositoryInterface $repository) {}

    public function execute(int $perPage = 10)
    {
        return $this->repository->paginate($perPage);
    }
} 