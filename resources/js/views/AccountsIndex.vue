<template>
  <div>
    <div v-if="loading">Carregando...</div>
    <div v-else>
        <div v-if="accounts.length === 0">
            <p>Não existem contas cadastradas.</p>
        </div>

        <div v-for="account in accounts" :key="account.id">
            <router-link :to="'/accounts/' + account.data.id" class="flex items-center border-b border-gray-400 p-4 hover:bg-red-100 hover:no-underline">
                
                <div class="pl-3">
                    <p class="font-bold text-gray-400">Cliente: {{ searchClient(account).data.name }}</p>
                    <div class="flex pt-4">
                        <p class="text-red-400 pr-4">Conta nº {{ account.data.id }}</p>
                        <p class="text-red-400 pr-4">Saldo: R$ {{ account.data.balance }}</p>
                        <p class="text-red-400 pr-4">Data de Abertura: {{ account.data.created_at }}</p>
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
    name: "AccountsIndex",

    components: {
        UserCircle
    },

    mounted() {
        axios.get('/api/accounts')
            .then(response => {
                this.accounts = response.data.data;

                
            })
            .catch(error=> {
                this.loading = false;

                alert('Não foi possível buscar as contas');
            });
        axios.get('/api/clients')
            .then(response=> {
                this.clients = response.data.data;
                this.loading = false;
            })
            .catch(error=> {
                this.loading = false;
                alert('Não foi possível buscar os clientes associados às contas');
            });
    },

    data: function () {
        return {
            loading: true,
            accounts: null,
            clients: null,
        }
    },

    methods: {
        searchClient: function ($account) {
            if (this.clients.length == null) return;
            for(let i = 0; i < this.clients.length; i++) {
                if (this.clients[i].data.id == $account.data.clients_id){
                    return this.clients[i];
                };
            };
        }
    }
}
</script>

<style>

</style>