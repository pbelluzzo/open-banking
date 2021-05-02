<template>
  <div>
    <div v-if="loading">Carregando...</div>
    <div v-else>
        <div v-if="products.length === 0">
            <p>Não existem clientes cadastrados.</p>
        </div>

        <div v-for="product in products" :key="product.id">
            <router-link :to="'/financial_products/' + product.data.id" class="flex items-center border-b border-gray-400 p-4 hover:bg-red-100 hover:no-underline">
                
                <div class="pl-3">
                    <p class="font-bold text-gray-400">{{ product.data.description }}</p>
                    <p class="text-red-400">{{ product.data.minimum_value }}</p>
                </div>
                
            </router-link>
        </div>
    </div>
  </div>
</template>

<script>
import UserCircle from '../components/UserCircle';
export default {
    name: "FinancialProductsIndex",

    components: {
        UserCircle
    },

    mounted() {
        axios.get('/api/financial_products')
            .then(response => {
                this.products = response.data.data;

                this.loading = false;
            })
            .catch(error=> {
                this.loading = false;

                alert('Não foi possível buscar os produtos');
            });
    },

    data: function () {
        return {
            loading: true,
            products: null,
        }
    }
}
</script>

<style>

</style>