<template>
    <div>
        <div v-if="loading">Carregando...</div>
        <div v-else>
            <div class="flex justify-between">
                <a href="#" class="text-red-300" @click="$router.back()">
                    Voltar
                </a>
                <div>
                    <router-link :to="'/financial_products/' + product.id + '/edit'" class="px-4 py-2 rounded text-sm text-green-500
                    border-2 border-green-500 font-bold mr-2 hover:no-underline hover:text-green-300 hover:border-green-300">Editar</router-link>
                    <a href="#" class="px-4 py-2 rounded text-sm text-red-500 border-2 border-red-500 font-bold hover:no-underline hover:text-red-300 hover:border-red-300">Deletar</a>
                </div>
            </div>

            <div class="flex items-center pt-6">
                <p class="pl-4 text-3xl">{{product.description}}</p>
            </div>

            <p class="pt-8 text-gray-400 font-bold uppercase font-xs">Valor Mínimo</p>
            <p class="pt-2 text-red-300 pl-4">{{ product.minimum_value }}</p>
            <p class="pt-8 text-gray-400 font-bold uppercase font-xs">Taxa de Administração</p>
            <p class="pt-2 text-red-300 pl-4">{{ product.administration_fee}}</p>

        </div>            

    </div>
</template>

<script>
export default {
    name: "FinancialProductsShow",

    components: {
    },

    props: [
        'user'
    ],

    mounted() {
        axios.get('/api/financial_products/' + this.$route.params.id)
        .then(response => {
            this.product = response.data.data;

            this.loading = false;
        })
        .catch(error => {
            this.loading = false;

            if (error.response.status === 404) {
                this.$router.push('/financial_products');
            }
        });
    },
    data: function() {
        return {
            loading: true,
            product: null,
        }
    }
}
</script>

<style>

</style>