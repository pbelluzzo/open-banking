<template>
    
    <div>
        <div class="flex justify-between">
                <a href="#" class="text-red-300" @click="$router.back()">
                    Voltar
                </a>
        </div>

        <div class="py-6">
            <p class="pl-4 text-xl">Editar Produto Financeiro</p>
        </div>

        <form @submit.prevent="submitForm">
            <InputField name="description" label="Descrição" placeholder="Descrição do Produto" :errors="errors" type="text" @update:field="form.description = $event" :data="form.description"/>

            <InputField name="minimum_value" label="Valor Mínimo" placeholder="Valor mínimo para aquisição" :errors="errors" type="text" @update:field="form.minimum_value = $event" :data="form.minimum_value"/>

            <InputField name="administration_fee" label="Taxa de Administração" placeholder="Taxa de administração do produto" :errors="errors" type="text" @update:field="form.administration_fee = $event" :data="form.administration_fee"/>

            <div class="flex justify-end">
                <router-link to="/"><button class="py-2 px-4 rounded border-2 hover:border-red-500 text-red-500 mr-5">Cancelar</button></router-link>
                <button class="bg-red-300 py-2 px-4 text-white rounded hover:bg-red-200">Salvar Alterações</button>
            </div>
        </form>
    </div>

</template>

<script>
    import InputField from '../components/InputField';
    export default {
        name: "FinancialProductsEdit",

        components: 
        {
            InputField,
        },

        data: function() {
            return {
                form: {
                    'financial_institutions_id' : '',
                    'description': '',
                    'minimum_value': '',
                    'administration_fee': '',
                },
                errors: null,
            }
        },

        mounted() {
        axios.get('/api/financial_products/' + this.$route.params.id)
        .then(response => {
            this.form = response.data.data;

        })
        .catch(error => {

            if (error.response.status === 404) {
                this.$router.push('/financial_products');
            }
        });
        },

        methods: {
            submitForm: function() {
                axios.patch('/api/financial_products/' + this.$route.params.id, this.form)
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
