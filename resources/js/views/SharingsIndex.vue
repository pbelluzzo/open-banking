<template>
  <div>
    <div v-if="loading">Carregando...</div>
    <div v-else>
        <div v-if="sharings.length === 0">
            <p class="text-red-300">Não existem compartilhamentos cadastrados.</p>
        </div>

        <div v-for="sharing in sharings" :key="sharing.id">
            <router-link :to="'/sharings/' + sharing.data.id" class="flex items-center border-b border-gray-400 p-4 hover:bg-red-100 hover:no-underline">
                
                <div class="pl-3">
                    <p class="font-bold text-gray-400">Cliente: {{ searchClient(sharing).data.name }}</p>
                    <div class="flex pt-4">
                        <p class="text-red-400 pr-4">Compartilhamento nº {{ sharing.data.id }}</p>
                        <p class="text-red-400 pr-4">Banco de Origem: {{ searchInstitution(sharing).data.fantasy_name }}</p>
                    </div>
                </div>
                
            </router-link>
        </div>
    </div>
  </div>
</template>

<script>
export default {
    name: "SharingsIndex",

    components: {
    },

    mounted() {
        axios.get('/api/sharings')
            .then(response => {
                this.sharings = response.data.data;

                
            })
            .catch(error=> {
                this.loading = false;

                alert('Não foi possível buscar os compartilhamentos');
            });
        axios.get('/api/financial_institutions')
            .then(response=> {
                this.institutions = response.data.data;
            })
            .catch(error=> {
                this.loading = false;
                alert('Não foi possível buscar as institutições associadas aos compartilhamentos');
            });
        axios.get('/api/clients')
            .then(response=> {
                this.clients = response.data.data;
                this.loading = false;
            })
            .catch(error=> {
                this.loading = false;
                alert('Não foi possível buscar os clientes associados aos compartilhamentos');
            });
    },

    data: function () {
        return {
            loading: true,
            sharings: null,
            institutions: null,
            clients: null,
        }
    },

    methods: {
        searchClient: function ($sharing) {
            for(let i = 0; i < this.clients.length; i++) {
                if (this.clients[i].data.id == $sharing.data.clients_id){
                    return this.clients[i];
                };
            };
        },
        searchInstitution: function ($sharing) {
            for(let i = 0; i < this.institutions.length; i++) {
                if (this.institutions[i].data.id == $sharing.data.origin_institution_id){
                    return this.institutions[i];
                };
            };
        }
    }
}
</script>

<style>

</style>