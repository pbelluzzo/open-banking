<template>
    <div>
        <div v-if="loading">Carregando...</div>
        <div v-else>
            <div class="flex justify-between">
                <a href="#" class="text-red-300" @click="$router.back()">
                    Voltar
                </a>
                <div v-if="contract.hiring_date == null">
                    <router-link :to="'/contracts/' + contract.id + '/edit'" class="px-4 py-2 rounded text-sm text-green-500
                    border-2 border-green-500 font-bold mr-2 hover:no-underline hover:text-green-300 hover:border-green-300">Editar</router-link>
                    <a href="#" class="px-4 py-2 rounded text-sm text-red-500 border-2 border-red-500 font-bold 
                    hover:no-underline hover:text-red-300 hover:border-red-300">Deletar</a>
                </div>
            </div>

            <div class="flex items-center pt-6">
                <p class="pl-4 text-xl">Contrato Nº {{contract.id}}</p>
            </div>

            <p class="pt-8 text-gray-400 font-bold uppercase font-xs">Identificador do Produto</p>
            <p class="pt-2 text-red-300 pl-4">{{ contract.financial_products_id }}</p>
            <p class="pt-8 text-gray-400 font-bold uppercase font-xs">Valor Investido</p>
            <p class="pt-2 text-red-300 pl-4">R${{ contract.amount_invested}}</p>
            <p class="pt-8 text-gray-400 font-bold uppercase font-xs">Taxa de Administração</p>
            <p class="pt-2 text-red-300 pl-4">{{ contract.administration_fee }}%</p>
            <p class="pt-8 text-gray-400 font-bold uppercase font-xs">Situação</p>
            <p v-if="contract.finished" class="pt-2 text-red-300 pl-4">Quitado</p>
            <p v-else class="pt-2 text-red-300 pl-4">Não Quitado</p>
            <p v-if="contract.hiring_date == null" class="pt-2 text-red-300 pl-4">Não Aceito</p>
            <p v-else class="pt-2 text-red-300 pl-4">Aceito</p>

            <div v-if="contract.hiring_date == null && user.entity_type == 'App\\Models\\Clients'">
                <form @submit.prevent="acceptContract" class="pt-6">
                    <button class="px-4 py-2 rounded text-sm text-green-500 border-2 border-green-500 font-bold
                    mr-2 hover:no-underline hover:text-green-300 hover:border-green-300">Aceitar Contrato</button>
                </form>
            </div>
            <div v-if="errors != null">
                <p class="pt-2 text-red-500 pl-4 font-bold text-sm animate-pulse">{{ errors }}!</p>
            </div>
        </div>            

    </div>
</template>

<script>
export default {
    name: "ContractsShow",

    components: {
    },

    props: [
        'user'
    ],

    mounted() {
        axios.get('/api/contracts/' + this.$route.params.id)
        .then(response => {
            this.contract = response.data.data;

            this.loading = false;
        })
        .catch(error => {
            this.loading = false;

            if (error.response.status === 404) {
                this.$router.push('/contracts');
            }
        });

        
    },
    data: function() {
        return {
            loading: true,
            contract: null,
            form: null,
            errors: null,
        }
    },
    methods: {
        acceptContract: function() {
            this.loading = true;
            this.setContractForm();
            axios.patch('/api/contracts/' + this.contract.id , this.form)
                .then(response => {
                    this.$router.push('/contracts');
            })
                .catch(errors => {
                    this.loading = false;
                    this.errors = errors.response.data.errors;
            });
        },

        setContractForm () {
            this.form = {
                'accounts_id' : this.contract.accounts_id,
                'financial_products_id' : this.contract.financial_products_id,
                'amount_invested' : this.contract.amount_invested,
                'administration_fee' : this.contract.administration_fee,
                'hiring_date' : this.getDate(),
                'finished' : this.contract.finished
            };
        },

        getDate () {
            let today = new Date();
            let now = today.getDate() + '/' + (today.getMonth() + 1) + '/' + today.getFullYear();
            return now;
        },
    }
}
</script>

<style>

</style>