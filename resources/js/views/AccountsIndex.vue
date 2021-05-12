<template>
  <div>
    <div v-if="loading">Carregando...</div>
    <div v-else>
        <div v-if="accounts.length === 0">
            <p>Não existem contas cadastradas.</p>
        </div>

        <div v-for="(account,index) in accounts" :key="account.id">
            <router-link :to="'/accounts/' + account.data.id" class="flex items-center border-b border-gray-400 p-4 hover:bg-red-100 hover:no-underline">
                
                <div class="pl-3">
                    <p class="font-bold text-gray-400">Cliente: {{ clients[index].name }}</p>
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
//import { use } from 'vue/types/umd';
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
                this.searchClients(response.data.data)
                .then(result=>{
                console.log(result);
                this.clients = result;
                this.loading =false;
                })
                .catch(error=>{
                    console.log(error);
                    alert('Não foi possível buscar os clientes associados às contas');
                });
            })
            .catch(error=> {
                console.log(error);
                this.loading = false;
                alert('Não foi possível buscar as contas');
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
        async searchClients($accounts) {
            let clients = [];
            for(let i = 0; i < $accounts.length; i++){
                await axios.get('/api/clients/' + $accounts[i].data.clients_id)
                .then(response=> {
                    clients[i] = response.data.data;
                })
                .catch(error=>{
                    console.log(error);
                    alert('Problema ao buscar cliente associado à conta ' + $accounts[i].data.id);
                })
            };
            return clients;
        },

    }
}
</script>

<style>

</style>