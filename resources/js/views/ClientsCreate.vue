<template>

    <div>
        <form @submit.prevent="submitForm">
            <InputField name="cpf" label="CPF" placeholder="CPF do Cliente" :errors="errors" @update:field="form.cpf = $event"/>

            <InputField name="name" label="Nome" placeholder="Nome do Cliente" :errors="errors" @update:field="form.name = $event"/>

            <InputField name="address" label="Endereço" placeholder="Endereço do Cliente" :errors="errors" @update:field="form.address = $event"/>

            <InputField name="birthdate" label="Data de Nascimento" placeholder="dd/mm/aaaa" :errors="errors" @update:field="form.birthdate = $event"/>

            <div>
                <p class="font-bold text-red-300">Atenção: Ao cadastrar um cliente, uma conta é aberta automáticamente</p>
            </div>
            <div class="flex justify-end">
                <router-link to="/"><button class="py-2 px-4 rounded border-2 hover:border-red-500 text-red-500 mr-5">Cancelar</button></router-link>
                <button class="bg-red-300 py-2 px-4 text-white rounded hover:bg-red-200">Adicionar Novo Cliente</button>
            </div>
        </form>
    </div>

</template>

<script>
    import InputField from '../components/InputField';

    export default {
        name: "ClientsCreate",

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
                    'cpf': '',
                    'name': '',
                    'address': '',
                    'birthdate': ''
                },

                account: {
                    'clients_id': '',
                    'financial_institutions_id': this.user.entity_id,
                    'balance' : 0,
                    'ended_in' : null
                },

                errors: null,
            }
        },

        methods: {
            submitForm: function() {
                axios.post('/api/clients', this.form)
                    .then(response => {
                        this.setAccountData(response.data.data.id);
                        this.createAccount();
                        this.$router.push(response.data.links.self);
                    })
                    .catch(errors => {
                        this.errors = errors.response.data.errors;
                    });
            },

            setAccountData: function(id) {
                this.account = {
                    'financial_institutions_id': this.user.entity_id,
                    'clients_id' : id,
                    'balance' : 0,
                    'ended_in' : null
                }
            },

            createAccount: function() {
                axios.post('/api/accounts', this.account)
                    .then(response => {
                    })
                    .catch(errors => {
                        this.errors = errors.response.data.errors;
                    });
            },
        }
    }
</script>

<style scoped>
</style>
