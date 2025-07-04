<script setup>
import { Link, usePage, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const page = usePage();

defineProps({
  contacts: {
    type: Object,
    default: () => ({ data: [] })
  }
});

// Estado para controlar a modal de confirmação
const showDeleteModal = ref(false);
const contactToDelete = ref(null);

const deleteContact = (contactId) => {
  contactToDelete.value = contactId;
  showDeleteModal.value = true;
};

const confirmDelete = () => {
  if (contactToDelete.value) {
    const deleteUrl = `/contacts/${contactToDelete.value}`;
    console.log('Deletando contato:', contactToDelete.value);
    console.log('URL de delete:', deleteUrl);
    
    // Usar POST com _method para simular DELETE
    const formData = new FormData();
    formData.append('_method', 'DELETE');
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    
    fetch(deleteUrl, {
      method: 'POST',
      body: formData
    })
    .then(response => {
      console.log('Response status:', response.status);
      if (response.ok) {
        console.log('Contato deletado com sucesso!');
        showDeleteModal.value = false;
        contactToDelete.value = null;
        // Redirecionar para a lista após sucesso
        window.location.href = '/contacts';
      } else {
        console.error('Erro ao deletar contato');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      showDeleteModal.value = false;
      contactToDelete.value = null;
    });
  }
};

const cancelDelete = () => {
  showDeleteModal.value = false;
  contactToDelete.value = null;
};
</script>

<template>
  <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
    <div class="bg-white rounded shadow p-8 w-full max-w-3xl">
      <div v-if="page.props.success" class="mb-4 p-3 bg-green-100 text-green-800 rounded text-center">
        {{ page.props.success }}
      </div>
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Contacts</h1>
        <Link href="/contacts/create" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">New Contact</Link>
      </div>
      <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
        <thead>
          <tr>
            <th class="px-4 py-2 border-b border-r border-gray-200">Name</th>
            <th class="px-4 py-2 border-b border-r border-gray-200">Email</th>
            <th class="px-4 py-2 border-b border-r border-gray-200">Phone</th>
            <th class="px-4 py-2 border-b border-gray-200">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="contact in contacts.data" :key="contact.id" class="hover:bg-gray-50">
            <td class="px-4 py-2 border-b border-r border-gray-200">{{ contact.name }}</td>
            <td class="px-4 py-2 border-b border-r border-gray-200">{{ contact.email }}</td>
            <td class="px-4 py-2 border-b border-r border-gray-200">{{ contact.phone }}</td>
            <td class="px-4 py-2 border-b border-gray-200">
              <div class="flex space-x-2">
                <Link 
                  :href="`/contacts/${contact.id}/edit`" 
                  class="text-blue-600 hover:text-blue-800 p-1 rounded hover:bg-blue-50"
                  title="Edit"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                  </svg>
                </Link>
                <button 
                  @click="deleteContact(contact.id)"
                  class="text-red-600 hover:text-red-800 p-1 rounded hover:bg-red-50"
                  title="Delete"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                  </svg>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <div v-if="!contacts.data || !contacts.data.length" class="text-gray-500 text-center mt-8">No contacts found.</div>
    </div>

    <!-- Modal de confirmação de exclusão -->
    <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <div class="flex items-center mb-4">
          <div class="flex-shrink-0">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
          </div>
          <div class="ml-3">
            <h3 class="text-lg font-medium text-gray-900">Delete Contact</h3>
          </div>
        </div>
        <div class="mb-6">
          <p class="text-sm text-gray-500">
            Are you sure you want to delete this contact? This action cannot be undone.
          </p>
        </div>
        <div class="flex justify-end space-x-3">
          <button
            @click="cancelDelete"
            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
          >
            Cancel
          </button>
          <button
            @click="confirmDelete"
            class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
          >
            Delete
          </button>
        </div>
      </div>
    </div>
  </div>
</template> 