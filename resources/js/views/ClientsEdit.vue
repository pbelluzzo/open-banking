<template>
    <div v-if="loading"> <!-- loading breaks update field / FIX THIS -->
        Carregando... 
    </div>
    <div v-else>
        <div class="flex justify-between">
                <a href="#" class="text-red-300" @click="$router.back()">
                    Voltar
                </a>
        </div>

        <div class="py-6">
            <p class="pl-4 text-xl">Editar Cliente</p>
        </div>

        <form @submit.prevent="submitForm">
            <InputField name="cpf" label="CPF" placeholder="CPF do Cliente" :errors="errors" @update:field="form.cpf = $event" :data="form.cpf"/>

            <InputField name="name" label="Nome" placeholder="Nome do Cliente" :errors="errors" @update:field="form.name = $event" :data="form.name"/>

            <InputField name="address" label="Endereço" placeholder="Endereço do Cliente" :errors="errors" @update:field="form.address = $event" :data="form.address"/>

            <InputField name="birthdate" label="Data de Nascimento" placeholder="dd/mm/aaaa" :errors="errors" @update:field="form.birthdate = $event" :data="form.birthdate"/>

            <div class="flex justify-end">
                <router-link to="/"><button class="py-2 px-4 rounded border-2 hover:border-red-500 text-red-500 mr-5">Cancelar</button></router-link>
                <button class="bg-red-300 py-2 px-4 text-white rounded hover:bg-red-200">Salvar Alterações</button>
            </div>
        </form>
    </div>

</template>

<script>
    import InputField from '../components/InputField';
    import UserCircle from '../components/UserCircle';
    export default {
        name: "ClientsEdit",

        components: 
        {
            InputField,
            UserCircle,
        },

        data: function() {
            return {
                form: {
                    'cpf': '',
                    'name': '',
                    'address': '',
                    'birthdate': ''
                },
                loading: true,
                errors: null,
            }
        },

        mounted() {
        axios.get('/api/clients/' + this.$route.params.id)
        .then(response => {
            this.form = response.data.data;
            this.loading = false;
        })
        .catch(error => {
            this.loading = false;
            if (error.response.status === 404) {
                this.$router.push('/');
            }
        });
        },

        methods: {
            submitForm: function() {
                axios.patch('/api/clients/' + this.$route.params.id, this.form)
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
