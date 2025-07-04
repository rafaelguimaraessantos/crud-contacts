<?php

namespace App\Repositories;

use App\Models\Contact;

interface ContactRepositoryInterface
{
    public function create(array $data): Contact;
    public function find(int $id): ?Contact;
    public function update(int $id, array $data): Contact;
    public function delete(int $id): void;
    public function paginate(int $perPage = 10);
} 