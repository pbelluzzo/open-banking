<template>

    <div>
        <form @submit.prevent="submitForm">
            <InputField name="cpf" label="CPF" placeholder="CPF do Cliente" :errors="errors" @update:field="form.cpf = $event"/>

            <InputField name="name" label="Nome" placeholder="Nome do Cliente" :errors="errors" @update:field="form.name = $event"/>

            <InputField name="address" label="Endereço" placeholder="Endereço do Cliente" :errors="errors" @update:field="form.address = $event"/>

            <InputField name="birthdate" label="Data de Nascimento" placeholder="dd/mm/aaaa" :errors="errors" @update:field="form.birthdate = $event"/>

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

                errors: null,
            }
        },

        methods: {
            submitForm: function() {
                axios.post('/api/clients', this.form)
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
