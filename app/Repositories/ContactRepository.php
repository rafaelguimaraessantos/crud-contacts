<?php

namespace App\Repositories;

use App\Models\Contact;

class ContactRepository implements ContactRepositoryInterface
{
    public function create(array $data): Contact
    {
        return Contact::create($data);
    }

    public function find(int $id): ?Contact
    {
        return Contact::find($id);
    }

    public function update(int $id, array $data): Contact
    {
        $contact = Contact::findOrFail($id);
        $contact->update($data);
        return $contact;
    }

    public function delete(int $id): void
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
    }

    public function paginate(int $perPage = 10)
    {
        return Contact::paginate($perPage);
    }
} 