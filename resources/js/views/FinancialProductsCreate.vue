<template>

    <div>
        <form @submit.prevent="submitForm">
            <InputField name="description" label="Descrição" placeholder="Descrição do Produto" :errors="errors" type="text" @update:field="form.description = $event"/>

            <InputField name="minimum_value" label="Valor Mínimo" placeholder="Valor mínimo para aquisição" :errors="errors" type="text" @update:field="form.minimum_value = $event"/>

            <InputField name="administration_fee" label="Taxa de Administração" placeholder="Taxa de administração do produto" :errors="errors" type="text" @update:field="form.administration_fee = $event"/>


            <div class="flex justify-end">
                <router-link to="/"><button class="py-2 px-4 rounded border-2 hover:border-red-500 text-red-500 mr-5">Cancelar</button></router-link>
                <button class="bg-red-300 py-2 px-4 text-white rounded hover:bg-red-200">Adicionar Novo Produto</button>
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
                    'financial_institutions_id' : this.user.entity_id,
                    'description': '',
                    'minimum_value': '',
                    'administration_fee': '',
                },

                errors: null,
            }
        },

        methods: {
            submitForm: function() {
                axios.post('/api/financial_products', this.form)
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
