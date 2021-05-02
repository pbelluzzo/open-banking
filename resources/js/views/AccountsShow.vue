<template>
    <div>
        <div v-if="loading">Carregando...</div>
        <div v-else>
            <div class="flex justify-between">
                <a href="#" class="text-red-300" @click="$router.back()">
                    Voltar
                </a>
                <div>
                    <router-link :to="'/accounts/' + account.id + '/edit'" class="px-4 py-2 rounded text-sm text-green-500
                    border-2 border-green-500 font-bold mr-2 hover:no-underline hover:text-green-300 hover:border-green-300">Editar</router-link>
                    <a href="#" class="px-4 py-2 rounded text-sm text-red-500 border-2 border-red-500 font-bold 
                    hover:no-underline hover:text-red-300 hover:border-red-300">Encerrar</a>
                </div>
            </div>

            <div class="flex items-center pt-6">
                <p class="pl-4 text-xl text-gray-400">Cliente: {{searchClient(account).data.name}}</p>
            </div>

            <div class="pb-6">
                <p class="pt-8 text-gray-400 font-bold uppercase font-xs">Identificador da conta</p>
                <p class="pt-2 text-red-300 pl-4">{{ account.id }}</p>
                <p class="pt-8 text-gray-400 font-bold uppercase font-xs">Saldo</p>
                <p class="pt-2 text-red-300 pl-4">{{ account.balance}}</p>
                <p class="pt-8 text-gray-400 font-bold uppercase font-xs">Data de Abertura</p>
                <p class="pt-2 text-red-300 pl-4">{{ account.created_at }}</p>
            </div>
            
            <div class="w-full bg-red-200 h-0.5"></div>

            <p class="pl-4 text-xl text-gray-400 pt-6">Produtos Contratados</p>

            <div class="py-12">
                <div v-if="contracts">

                </div>
                <div v-else>
                    <p class="pt-2 text-red-300 pl-4">Não existem produtos contratados.</p>
                </div>

            </div>

            <div class="pl-8">
                <router-link :to="'/'" class="px-4 py-2 rounded text-sm text-green-500
                border-2 border-green-500 font-bold mr-2 hover:no-underline hover:text-green-300 hover:border-green-300">Contratar Produto Financeiro</router-link>
            </div>

        </div>            

    </div>
</template>

<script>
export default {
    name: "AccountsShow",

    components: {
    },

    props: [
        'user'
    ],

    mounted() {
        axios.get('/api/accounts/' + this.$route.params.id)
        .then(response => {
            this.account = response.data.data;

        })
        .catch(error => {
            this.loading = false;

            if (error.response.status === 404) {
                this.$router.push('/accounts');
            }
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
    data: function() {
        return {
            loading: true,
            account: null,
            clients: null,
            contracts: null,
        }
    },

    methods: {
        searchClient: function ($account) {
            if (this.clients.length == null) return;
            for(let i = 0; i < this.clients.length; i++) {
                if (this.clients[i].data.id == $account.clients_id){
                    return this.clients[i];
                };
            };
        }
    }
    
}
</script>

<style>

</style>