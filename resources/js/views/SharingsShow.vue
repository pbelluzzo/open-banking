<template>
    <div>
        <div v-if="loading">Carregando...</div>
        <div v-else>
            <div class="flex justify-between">
                <a href="#" class="text-red-300" @click="$router.back()">
                    Voltar
                </a>
            </div>

            <div class="flex items-center pt-6">
                <p class="pl-4 text-xl">Cliente {{client.name}}</p>
            </div>

            <p class="pt-8 text-gray-400 font-bold uppercase font-xs">Identificador do Compartilhamento</p>
            <p class="pt-2 text-red-300 pl-4">{{ sharing.id }}</p>
            <p class="pt-8 text-gray-400 font-bold uppercase font-xs">Banco de Origin</p>
            <p class="pt-2 text-red-300 pl-4">{{ institution.fantasy_name}}</p>
            <p class="pt-8 text-gray-400 font-bold uppercase font-xs">Compartilhamento Válido</p>
            <p v-if="persisted" class="pt-2 text-red-300 pl-4">Sim</p>
            <p v-else class="pt-2 text-red-300 pl-4">Não</p>

            <div v-if="persisted" class="pt-6">
                <button class="px-4 py-2 rounded text-sm text-green-500
                border-2 border-green-500 font-bold mr-2 hover:no-underline hover:text-green-300 hover:border-green-300">Acessar compartilhamento</button>
            </div>

        </div>            

    </div>
</template>

<script>
export default {
    name: "SharingsShow",

    components: {
    },

    props: [
        'user'
    ],

    mounted() {
        axios.get('/api/sharings/' + this.$route.params.id)
        .then(response => {
            this.sharing = response.data.data;
            this.getInstitution()
                .then(response=> {
                    this.getClient()
                        .then(response => {
                            this.checkPersistance();
                            this.loading = false;
                        })
                        .catch(error => {
                            this.loading =false;
                        })
                })
                .catch(error => {
                    
                    });
        })
        .catch(error => {
            this.loading = false;

            if (error.response.status === 404) {
                this.$router.push('/sharings');
            }
        }); 
         
    },

    data: function() {
        return {
            loading: true,
            client: null,
            institution: null,
            sharing: null,
            persisted: '',
        }
    },

    methods: {
        async getInstitution() {
            axios.get('/api/financial_institutions/' + this.sharing.origin_institution_id)
                .then(response=> {
                    this.institution = response.data.data;
            })
                .catch(error=> {
            });
        },

        async getClient() {
            axios.get('/api/clients/' + this.sharing.clients_id)
                .then(response=> {
                    this.client = response.data.data;
                })
                .catch(error=> {
                });
        },

        checkPersistance() {
            console.log('called');
            this.persisted = this.sharing.acceptance_date != null;
        }
    }

}
</script>

<style>

</style>