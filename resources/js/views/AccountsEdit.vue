<template>
    
    <div>
        <div class="flex justify-between">
                <a href="#" class="text-red-300" @click="$router.back()">
                    Voltar
                </a>
        </div>

        <div class="py-6">
            <p class="pl-4 text-xl">Editar Conta</p>
        </div>

        <form @submit.prevent="submitForm">
            <InputField name="balance" label="Saldo" placeholder="Saldo da Conta" :errors="errors" @update:field="form.balance = $event" :data="form.balance"/>

            <div class="flex justify-end">
                <router-link :to="'/accounts/' + this.$route.params.id"><button class="py-2 px-4 rounded border-2 hover:border-red-500 text-red-500 mr-5">Cancelar</button></router-link>
                <button class="bg-red-300 py-2 px-4 text-white rounded hover:bg-red-200">Salvar Alterações</button>
            </div>
        </form>
    </div>

</template>

<script>
    import InputField from '../components/InputField';
    export default {
        name: "AccountsEdit",

        components: 
        {
            InputField,
        },

        data: function() {
            return {
                form: {
                    'clients_id': '',
                    'financial_institutions_id': 's',
                    'balance' : '',
                    'ended_in' : null
                },
                errors: null,
            }
        },

        mounted() {
        axios.get('/api/accounts/' + this.$route.params.id)
        .then(response => {
            this.form = response.data.data;

        })
        .catch(error => {

            if (error.response.status === 404) {
                this.$router.push('/accounts');
            }
        });
        },

        methods: {
            submitForm: function() {
                axios.patch('/api/accounts/' + this.$route.params.id, this.form)
                    .then(response => {
                        this.$router.push(response.data.links.self);
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
