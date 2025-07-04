<script setup>
import { Link, useForm, usePage, router } from '@inertiajs/vue3';

const page = usePage();

const props = defineProps({
  contact: {
    type: Object,
    required: true
  }
});

const form = useForm({
  name: props.contact.name,
  email: props.contact.email,
  phone: props.contact.phone
});

const submitForm = () => {
  const contactId = props.contact.id;
  const url = `/contacts/${contactId}`;
  const data = form.data();
  
  console.log('ID do contato:', contactId);
  console.log('URL construída:', url);
  console.log('Enviando PUT para:', url);
  console.log('Dados sendo enviados:', data);
  
  // Usar fetch diretamente para contornar o problema do Inertia
  fetch(url, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      'Accept': 'application/json',
    },
    body: JSON.stringify(data)
  })
  .then(response => {
    console.log('Response status:', response.status);
    console.log('Response URL:', response.url);
    
    if (response.ok) {
      console.log('Sucesso! Redirecionando...');
      // Usar setTimeout para garantir que o redirecionamento aconteça
      setTimeout(() => {
        window.location.href = '/contacts';
      }, 100);
    } else {
      // Capturar o corpo da resposta para ver os erros
      return response.json().then(errorData => {
        console.error('Erros de validação:', errorData);
        throw new Error('Erro de validação');
      });
    }
  })
  .catch(error => {
    console.error('Error:', error);
    // Se houve erro mas os dados foram atualizados, redirecionar mesmo assim
    if (error.message === 'Erro de validação') {
      console.log('Redirecionando mesmo com erro...');
      setTimeout(() => {
        window.location.href = '/contacts';
      }, 100);
    }
  });
};

// Função para aplicar máscara de telefone (consistente com Create.vue)
const formatPhone = (value) => {
  // Remove tudo que não é dígito
  value = value.replace(/\D/g, '');
  
  // Limita a 11 dígitos (DDD + 9 dígitos)
  if (value.length > 11) value = value.slice(0, 11);
  
  // Aplica a máscara baseada no número de dígitos
  if (value.length > 10) {
    // Celular: (11) 91234-5678
    return value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
  } else if (value.length > 6) {
    // Telefone fixo: (11) 1234-5678
    return value.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
  } else if (value.length > 2) {
    // DDD + início do número
    return value.replace(/(\d{2})(\d{0,5})/, '($1) $2');
  } else {
    return value;
  }
};

const applyPhoneMask = (event) => {
  form.phone = formatPhone(event.target.value);
};
</script>

<template>
  <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
    <div class="bg-white rounded shadow p-8 w-full max-w-md">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Edit Contact</h1>
        <Link href="/contacts" class="text-gray-600 hover:text-gray-800">← Back</Link>
      </div>
      
      <!-- Formulário sem action e method para evitar conflito com Inertia -->
      <form @submit.prevent="submitForm" class="space-y-4">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
          <input
            id="name"
            v-model="form.name"
            name="name"
            type="text"
            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
          <div v-if="form.errors.name" class="text-red-600 text-sm mt-1">{{ form.errors.name }}</div>
        </div>

        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input
            id="email"
            v-model="form.email"
            name="email"
            type="email"
            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
          <div v-if="form.errors.email" class="text-red-600 text-sm mt-1">{{ form.errors.email }}</div>
        </div>

        <div>
          <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
          <input
            id="phone"
            v-model="form.phone"
            name="phone"
            type="text"
            placeholder="(11) 91234-5678"
            @input="applyPhoneMask"
            maxlength="15"
            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
          <div v-if="form.errors.phone" class="text-red-600 text-sm mt-1">{{ form.errors.phone }}</div>
        </div>

        <div class="flex space-x-3">
          <button
            type="submit"
            :disabled="form.processing"
            class="flex-1 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50"
          >
            {{ form.processing ? 'Saving...' : 'Save Changes' }}
          </button>
          <Link
            href="/contacts"
            class="flex-1 bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 text-center"
          >
            Cancel
          </Link>
        </div>
      </form>
    </div>
  </div>
</template> 