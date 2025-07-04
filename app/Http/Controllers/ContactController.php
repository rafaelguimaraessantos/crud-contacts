<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Actions\Contact\CreateContact;
use App\Actions\Contact\UpdateContact;
use App\Actions\Contact\DeleteContact;
use App\Actions\Contact\ListContacts;
use App\Models\Contact;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index(ListContacts $action)
    {
        $contacts = $action->execute();
        return Inertia::render('Contacts/Index', [
            'contacts' => $contacts
        ]);
    }

    public function edit(Contact $contact)
    {
        return Inertia::render('Contacts/Edit', [
            'contact' => $contact
        ]);
    }

    public function store(ContactRequest $request, CreateContact $action)
    {
        $contact = $action->execute($request->validated());
        return redirect()->route('contacts.index')->with('success', 'Contact created successfully!');
    }

    public function update(ContactRequest $request, UpdateContact $action, $id)
    {
        \Log::info('Dados recebidos:', $request->all());
        \Log::info('ID do contato:', ['id' => $id]);
        
        try {
            $validatedData = $request->validated();
            \Log::info('Dados validados:', $validatedData);
            
            $contact = $action->execute($id, $validatedData);
            \Log::info('Contato atualizado:', $contact->toArray());
            
            return redirect()->route('contacts.index')->with('success', 'Contact updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Erro ao atualizar contato:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()->withErrors(['error' => 'Erro ao atualizar contato']);
        }
    }

    public function destroy(DeleteContact $action, $id)
    {
        $action->execute($id);
        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully!');
    }
} 