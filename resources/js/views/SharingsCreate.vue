<template>

    <div>
        <div v-if="step == 0">Carregando...</div>
        <div v-if="step >= 1">
            <p class="font-bold text-gray-400 text-xl pb-8"> Definindo Compartilhamento - Passo {{this.step}}</p>
            <div v-if="step == 1">    
                <div v-if="clients.length > 0">
                    <div v-for="client in clients" :key="client.id">
                        <button v-on:click="selectClient(client)" class="flex items-start w-full p-4 border-b border-gray-400 hover:bg-red-100 hover:no-underline">
                            <div class="pl-0 ml-0">
                                <p class="font-bold text-gray-400 pl-0 ml-0">Cliente: {{ client.data.name }}</p>
                                <div class="flex pt-4">
                                    <p class="text-red-400 pr-4">CPF: {{ client.data.cpf }}</p>
                                    <p class="text-red-400 pr-4">Data de Nascimento {{ client.data.birthdate }}</p>
                                </div>
                            </div>                                
                        </button>                
                    </div>    
                </div>            
                <div v-else class="text-red-400 font-bold">Nenhum cliente cadastrado!</div>          
            </div>

            <div v-if="step == 2">
                <div v-if="institutions.length > 0">
                    <div v-for="institution in institutions" :key="institution.id">  
                        <button v-on:click="selectInstitution(institution)" class="flex items-start w-full p-4 border-b border-gray-400 hover:bg-red-100 hover:no-underline">
                            <div class="pl-3">
                                <p class="font-bold text-gray-400">Instituição: {{ institution.data.company_name }}</p>
                                <div class="flex pt-4">
                                    <p class="text-red-400 pr-4">CNPJ: {{ institution.data.cnpj }}</p>
                                    <p class="text-red-400 pr-4">Nome Fantasia: {{ institution.data.fantasy_name }}</p>
                                    <p class="text-red-400 pr-4">Código Bancário: {{ institution.data.bank_code }}</p>
                                </div>
                            </div>                
                        </button>              
                    </div>          
                </div>
                <div v-else class="text-red-400 font-bold">Nenhuma instituição cadastrada!</div>
            </div>

            <div v-if="step == 3">
                <form @submit.prevent="submitForm">

                    <div class="py-6">
                        <p class="font-bold text-red-300 text-xl">Atenção: O cliente precisará autorizar o compartilhamento antes que o mesmo seja válido e o arquivo seja recebido</p>
                        <p class="text-red-300 pt-6 text-lg">Deseja continuar com o compartilhamento?</p>
                    </div>
                    
                    <div class="flex justify-end">
                        <router-link to="/"><button class="py-2 px-4 rounded border-2 hover:border-red-500 text-red-500 mr-5">Cancelar</button></router-link>
                        <button class="bg-red-300 py-2 px-4 text-white rounded hover:bg-red-200">Registrar Compartilhamento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</template>

<script>
    import InputField from '../components/InputField';

    export default {
        name: "SharingsCreate",

        props: [
            'user'
        ],

        components: 
        {
            InputField,
        },

        data: function() {
            return {
                form: {
                    'clients_id': '',
                    'origin_institution_id': '',
                    'destiny_institution_id': this.user.entity_id,
                    'acceptance_date': '',
                    'xml_path' : '',
                },

                step: 0,
                clients: null,
                institutions: null,
                errors: null,
            }
        },

        mounted() {
            axios.get('/api/clients')
            .then(response => {
                this.clients = response.data.data;
            })
            .catch(error=> {
                alert('Não foi possível buscar os clients');
                this.loading = false;
                this.$router.push('/sharings');
            });
            axios.get('/api/financial_institutions')
            .then(response => {
                this.institutions = response.data.data;
                this.loading = false;
                this.iterateStep();
            })
            .catch(error=> {
                alert('Não foi possível buscar as instituições');
                this.loading = false;
                this.$router.push('/sharings');
            });
        },

        methods: {
            submitForm: function() {
                axios.post('/api/sharings', this.form)
                    .then(response => {
                        this.$router.push(response.data.links.self);
                    })
                    .catch(errors => {
                        this.errors = errors.response.data.errors;
                    });
            },

            iterateStep: function() {
                this.step ++;
            },

            selectClient: function($client) {
                this.form.clients_id = $client.data.id;
                this.iterateStep();
            },

            selectInstitution: function($institution) {
                this.form.origin_institution_id = $institution.data.id;
                this.iterateStep();
            },
        }
    }
</script>

<style scoped>
</style>
