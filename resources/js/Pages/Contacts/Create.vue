<template>
  <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
    <div class="bg-white rounded shadow p-8 w-full max-w-md">
      <h1 class="text-2xl font-bold mb-4">New Contact</h1>
      <form @submit.prevent="submit">
        <div class="mb-4">
          <label class="block mb-1 font-semibold">Name</label>
          <input v-model="form.name" type="text" class="w-full border rounded px-3 py-2" required />
        </div>
        <div class="mb-4">
          <label class="block mb-1 font-semibold">Email</label>
          <input v-model="form.email" type="email" class="w-full border rounded px-3 py-2" required />
        </div>
        <div class="mb-4">
          <label class="block mb-1 font-semibold">Phone</label>
          <input v-model="form.phone" type="text" class="w-full border rounded px-3 py-2" @input="onPhoneInput" maxlength="15" />
        </div>
        <div v-if="form.errors" class="mb-4 text-red-600">
          <div v-for="(error, key) in form.errors" :key="key">{{ error }}</div>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
        <Link href="/contacts" class="ml-4 text-gray-600 hover:underline">Cancel</Link>
      </form>
    </div>

    <!-- Modal de sucesso -->
    <div v-if="showSuccessModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <div class="flex items-center mb-4">
          <div class="flex-shrink-0">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
          </div>
          <div class="ml-3">
            <h3 class="text-lg font-medium text-gray-900">Contact Created Successfully!</h3>
          </div>
        </div>
        <div class="mb-6">
          <p class="text-sm text-gray-500">
            Your contact has been created successfully. You will be redirected to the contacts list.
          </p>
        </div>
        <div class="flex justify-end">
          <button
            @click="goToList"
            class="px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
          >
            Go to List
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { router, Link } from '@inertiajs/vue3';

const form = reactive({
  name: '',
  email: '',
  phone: '',
  errors: null
});

const showSuccessModal = ref(false);

function formatPhone(value) {
  // Máscara para telefone/celular brasileiro: (99) 99999-9999 ou (99) 9999-9999
  value = value.replace(/\D/g, '');
  if (value.length > 11) value = value.slice(0, 11);
  if (value.length > 10) {
    return value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
  } else if (value.length > 6) {
    return value.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
  } else if (value.length > 2) {
    return value.replace(/(\d{2})(\d{0,5})/, '($1) $2');
  } else {
    return value;
  }
}

function onPhoneInput(e) {
  form.phone = formatPhone(e.target.value);
}

function submit() {
  router.post('/contacts', form, {
    onError: (errors) => {
      form.errors = errors;
    },
    onSuccess: () => {
      form.name = '';
      form.email = '';
      form.phone = '';
      form.errors = null;
      showSuccessModal.value = true;
    }
  });
}

function goToList() {
  showSuccessModal.value = false;
  router.visit('/contacts');
}
</script> 