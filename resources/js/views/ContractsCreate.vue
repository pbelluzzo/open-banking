<template>

    <div>
        <div v-if="step == 0">Carregando...</div>
        <div v-if="step >= 1">
            <p class="font-bold text-gray-400 text-xl pb-8"> Definindo Contrato - Passo {{this.step}}</p>
            <div v-if="step == 1">
                <div v-for="product in this.products" :key="product.id">
                    <button v-on:click="selectProduct(product)" class="flex items-start w-full p-4 border-b border-gray-400 hover:bg-red-100 hover:no-underline">
                        <div class="pl-0 ml-0">
                            <p class="font-bold text-gray-400 pl-0 ml-0">Produto: {{ product.data.description }}</p>
                            <div class="flex pt-4">
                                <p class="text-red-400 pr-4">Valor Mínimo: R$ {{ product.data.minimum_value }}</p>
                                <p class="text-red-400 pr-4">Taxa de Administração: {{ product.data.administration_fee }}%</p>
                            </div>
                        </div>                                
                    </button>                
                </div>          
            </div>

            <div v-if="step == 2">
                <div v-for="account in accounts" :key="account.id">  
                    <button v-on:click="selectAccount(account)" class="flex items-start w-full p-4 border-b border-gray-400 hover:bg-red-100 hover:no-underline">
                        <div class="pl-3">
                            <p class="font-bold text-gray-400">Conta: {{ account.data.id }}</p>
                            <div class="flex pt-4">
                                <p class="text-red-400 pr-4">Saldo: R$ {{ account.data.balance }}</p>
                            </div>
                        </div>                
                    </button>              
                </div>          
            </div>

            <div v-if="step == 3">
                <form @submit.prevent="submitForm">
                    <InputField name="amount_invested" label="Valor Investido" placeholder="O valor precisa ser superior ao valor mínimo do produto" :errors="errors" @update:field="form.amount_invested = $event"/>

                    <div>
                        <p class="font-bold text-red-300">Atenção: O cliente precisará aceitar o contrato antes que o mesmo seja válido</p>
                    </div>
                    <div class="flex justify-end">
                        <router-link to="/"><button class="py-2 px-4 rounded border-2 hover:border-red-500 text-red-500 mr-5">Cancelar</button></router-link>
                        <button class="bg-red-300 py-2 px-4 text-white rounded hover:bg-red-200">Adicionar Contrato</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</template>

<script>
    import InputField from '../components/InputField';

    export default {
        name: "ContractsCreate",

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
                    'accounts_id': '',
                    'financial_products_id': '',
                    'amount_invested': '',
                    'administration_fee': '',
                    'hiring_date' : '',
                    'finished' : '0',
                },

                step: 0,
                products: null,
                accounts: null,
                errors: null,
            }
        },

        mounted() {
            axios.get('/api/financial_products')
            .then(response => {
                this.products = response.data.data;
            })
            .catch(error=> {
                alert('Não foi possível buscar os produtos financeiros');
                this.$router.push('/accounts');
            });
            axios.get('/api/accounts')
            .then(response => {
                this.accounts = response.data.data;
                this.iterateStep();
            })
            .catch(error=> {
                alert('Não foi possível buscar as contas');
                this.$router.push('/accounts');
            });
        },

        methods: {
            submitForm: function() {
                axios.post('/api/contracts', this.form)
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

            selectProduct: function($product) {
                this.form.financial_products_id = $product.data.id;
                this.form.administration_fee = $product.data.administration_fee;
                this.iterateStep();
            },

            selectAccount: function($account) {
                this.form.accounts_id = $account.data.id;
                this.iterateStep();
            },
        }
    }
</script>

<style scoped>
</style>
