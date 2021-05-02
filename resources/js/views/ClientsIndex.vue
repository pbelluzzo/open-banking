<template>
  <div>
    <div v-if="loading">Carregando...</div>
    <div v-else>
        <div v-if="clients.length === 0">
            <p>Não existem clientes cadastrados.</p>
        </div>

        <div v-for="client in clients" :key="client.id">
            <router-link :to="'/clients/' + client.data.id" class="flex items-center border-b border-gray-400 p-4 hover:bg-red-100 hover:no-underline">
                <UserCircle :name="client.data.name" /> 
                
                <div class="pl-3">
                    <p class="font-bold text-gray-400">{{ client.data.name }}</p>
                    <div class="flex pt-4">
                        <p class="text-red-400 pr-4">{{ client.data.cpf }}</p>
                        <p class="text-red-400 pr-4">{{ client.data.address}}</p>                  
                    </div>
                </div>                
            </router-link>
        </div>
    </div>
  </div>
</template>

<script>
import UserCircle from '../components/UserCircle';
export default {
    name: "FinancialProductsIndex",

    components: {
        UserCircle,
    },

    mounted() {
        axios.get('/api/clients')
            .then(response => {
                this.clients = response.data.data;

                this.loading = false;
            })
            .catch(error=> {
                this.loading = false;

                alert('Não foi possível buscar os clientes');
            });
    },

    data: function () {
        return {
            loading: true,
            clients: null,
        }
    }
}
</script>

<style>

</style>