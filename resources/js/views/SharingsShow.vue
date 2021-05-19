<template>
    <div>
        <div v-if="loading">Carregando...</div>
        <div v-else>
            <div class="flex justify-between">
                <a href="#" class="text-red-300" @click="$router.back()">
                    Voltar
                </a>
            </div>

            <div class="flex items-center pt-6 text-red-300">

                <div v-if="userIsInstitution()" class="flex flex-direction-row">
                    <p class="pl-4 text-xl font-bold text-gray-400"> Cliente : </p>                    
                    <p class="pl-2 text-xl">{{client.name}}</p>
                </div>

                <div v-else class="flex flex-direction-row">
                    <p class="pl-4 text-xl font-bold text-gray-400"> Institição destino : </p>
                    <p class="pl-2 text-xl">{{ institution.destiny.fantasy_name }}</p>
                </div>
            </div>

            <p class="pt-8 text-gray-400 font-bold uppercase font-xs">Identificador do Compartilhamento</p>
            <p class="pt-2 text-red-300 pl-4">{{ sharing.id }}</p>
            <p class="pt-8 text-gray-400 font-bold uppercase font-xs">Instituição de Origem</p>
            <p class="pt-2 text-red-300 pl-4">{{ institution.origin.fantasy_name}}</p>
            <p class="pt-8 text-gray-400 font-bold uppercase font-xs">Compartilhamento Válido</p>
            <p v-if="persisted" class="pt-2 text-red-300 pl-4">Sim</p>
            <p v-else class="pt-2 text-red-300 pl-4">Não</p>

            <div v-if="persisted && userIsInstitution()" class="pt-6">
                <button class="px-4 py-2 rounded text-sm text-green-500
                border-2 border-green-500 font-bold mr-2 hover:no-underline hover:text-green-300 hover:border-green-300">Acessar compartilhamento</button>
            </div>
            <div v-else-if="!userIsInstitution()" class="flex flex-direction-row pt-6">
                <form @submit.prevent="confirmSharing" v-if="sharing.acceptance_date == null">
                    <button class="px-4 py-2 rounded text-sm text-green-500 border-2 border-green-500 font-bold
                     mr-2 hover:no-underline hover:text-green-300 hover:border-green-300">Confirmar Compartilhamento</button>
                </form>

                <form @submit.prevent="deleteSharing" class="pl-4">
                    <button class="px-4 py-2 rounded text-sm text-red-500 border-2 border-red-500 font-bold 
                    hover:no-underline hover:text-red-300 hover:border-red-300">Encerrar Compartilhamento</button>
                </form>
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
                        })
                })
                .catch(error => {
                    
                    });
        })
        .catch(error => {

            if (error.response.status === 404) {
                this.$router.push('/sharings');
            }
        }); 
         
    },

    data: function() {
        return {
            loading: true,
            client: null,
            institution: {
                origin : '',
                destiny : '',
            },
            sharing: null,
            persisted: '',
        }
    },

    methods: {
        async getInstitution() {
            await axios.get('/api/financial_institutions/' + this.sharing.origin_institution_id)
                .then(response=> {
                    this.institution.origin = response.data.data;
            })
                .catch(error=> {
            });
            await axios.get('/api/financial_institutions/' + this.sharing.destiny_institution_id)
                .then(response=> {
                    this.institution.destiny = response.data.data;
            })
                .catch(error=> {
            });
        },

        async getClient() {
            await axios.get('/api/clients/' + this.sharing.clients_id)
                .then(response=> {
                    this.client = response.data.data;
                })
                .catch(error=> {
                });
        },

        checkPersistance() {
            this.persisted = this.sharing.acceptance_date != null;
        },

        userIsInstitution(){
            return this.user.entity_type == 'App\\Models\\FinancialInstitutions';
        },

        confirmSharing(){
            let form = this.getForm();
            form.acceptance_date = this.getDate();
            axios.patch('/api/sharings/' + this.$route.params.id, form)
                    .then(response => {
                        this.$router.push('/sharings');
                    })
                    .catch(errors => {
                        this.errors = errors.response.data.errors;
                        alert("Não foi possível confirmar o compartilhamento");
                    });
        },

        deleteSharing(){
            axios.delete('/api/sharings/' + this.$route.params.id, form)
                    .then(response => {
                        this.$router.push('/sharings');
                    })
                    .catch(errors => {
                        this.errors = errors.response.data.errors;
                        alert("Não foi possível encerrar o compartilhamento");
                    });
        },

        getDate () {
            let today = new Date();
            let now = today.getDate() + '/' + (today.getMonth() + 1) + '/' + today.getFullYear();
            return now;
        },

        getForm() {
            return {
                'clients_id' : this.sharing.clients_id,
                'origin_institution_id' : this.sharing.origin_institution_id,
                'destiny_institution_id' : this.sharing.destiny_institution_id,
                'acceptance_date' : this.sharing.acceptance_date,
                'xml_path' : this.sharing.xml_path
            };
        }
    }

}
</script>

<style>

</style>