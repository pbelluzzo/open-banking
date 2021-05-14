<template>
  <div>
    <div v-if="loading">Carregando...</div>
    <div v-else>
        <div v-if="sharings.length === 0">
            <p class="text-red-300">Não existem compartilhamentos cadastrados.</p>
        </div>

        <div v-for="(sharing,index) in sharings" :key="sharing.id">
            <router-link :to="'/sharings/' + sharing.data.id" class="flex items-center border-b border-gray-400 p-4 hover:bg-red-100 hover:no-underline">
                
                <div v-if="userIsInstitution()" class="pl-3">
                    <p class="font-bold text-gray-400">Cliente: {{ clients[index].name }}</p>
                    <div class="flex pt-4">
                        <p class="text-red-400 pr-4">Compartilhamento nº {{ sharing.data.id }}</p>
                        <p class="text-red-400 pr-4">Instituição de Origem: {{ institutions.origin[index].fantasy_name }}</p>
                        <p class="text-red-400 pr-4">Instituição de Destino: {{ institutions.destiny[index].fantasy_name }}</p>
                    </div>
                </div>

                <div v-else class="pl-3">
                    <p class="font-bold text-gray-400">Compartilhamento nº {{ sharing.data.id }}</p>
                    <div class="flex pt-4">
                        <p class="text-red-400 pr-4">Instituição de Origem: {{ institutions.origin[index].fantasy_name }}</p>
                        <p class="text-red-400 pr-4">Instituição de Destino: {{ institutions.destiny[index].fantasy_name }}</p>
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

    props : [
        'user'
    ],

    mounted() {
        axios.get('/api/sharings')
            .then(response => {
                this.sharings = response.data.data;
                this.searchInstitutions(this.sharings)
                    .then(response=> {
                        this.institutions = response;
                        if (this.userIsInstitution()){
                            this.searchClients(this.sharings)
                                .then(response=> {
                                    this.clients = response;
                                    this.loading = false;
                                })
                                .catch(error=> {
                                    console.log(error);
                                    alert('Não foi possível buscar os clientes associados aos compartilhamentos');
                                })
                        }
                        else{
                            this.loading = false;
                        }
                    })
                    .catch(error=> {
                        console.log(error);
                        alert('Não foi possível buscar as instituições associadas aos compartilhamentos');
                    })
                
            })
            .catch(error=> {
                this.loading = false;
                console.log(error);
                alert('Não foi possível buscar os compartilhamentos');
            });
        //axios.get('/api/financial_institutions')
        //    .then(response=> {
        //        this.institutions = response.data.data;
        //        this.loading = false;
        //    })
        //    .catch(error=> {
        //        this.loading = false;
        //        alert('Não foi possível buscar as institutições associadas aos compartilhamentos');
        //    });      
        //axios.get('/api/clients')
        //    .then(response=> {
        //        this.clients = response.data.data;
        //        this.loading = false;
        //    })
        //    .catch(error=> {
        //        this.loading = false;
        //        alert('Não foi possível buscar os clientes associados aos compartilhamentos');
        //    });
            
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
        async searchInstitutions($sharings) {
            let institutions = {
                origin : [],
                destiny : [],
            };
            for(let i = 0; i < $sharings.length; i++){
                await axios.get('/api/financial_institutions/' + $sharings[i].data.origin_institution_id)
                .then(response=> {
                    institutions.origin[i] = response.data.data;
                })
                .catch(error=>{
                    console.log(error);
                    alert('Problema ao buscar instituição de origem associada ao compartilhamento ' + $sharings[i].data.id);
                });
                await axios.get('/api/financial_institutions/' + $sharings[i].data.destiny_institution_id)
                .then(response=> {
                    institutions.destiny[i] = response.data.data;
                })
                .catch(error=>{
                    console.log(error);
                    alert('Problema ao buscar instituição destino associada ao compartilhamento ' + $sharings[i].data.id);
                })
                
            };
            return institutions;
        },
        async searchClients($sharings) {
            let clients = [];
            for(let i = 0; i < $sharings.length; i++){
                await axios.get('/api/clients/' + $sharings[i].data.clients_id)
                .then(response=> {
                    clients[i] = response.data.data;
                })
                .catch(error=>{
                    console.log(error);
                    alert('Problema ao buscar cliente associado ao compartilhamento ' + $sharings[i].data.id);
                });
            }
            return clients;
        },
        userIsInstitution(){
            return this.user.entity_type == 'App\\Models\\FinancialInstitutions';
        }
    }
}
</script>

<style>

</style>