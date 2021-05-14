<template>
  <div>
    <div v-if="loading">Carregando...</div>
    <div v-else>
        <div v-if="contracts.length === 0">
            <p>Não existem contratos cadastrados.</p>
        </div>

        <div v-for="(contract,index) in contracts" :key="contract.id">
            <router-link :to="'/contracts/' + contract.data.id" class="flex items-center border-b border-gray-400 p-4 hover:bg-red-100 hover:no-underline">
                
                <div class="pl-3">
                    <p class="font-bold text-gray-400">Contrato Nº {{ contract.data.id }} - {{products[index].description}} </p>
                    <div class="flex pt-4">
                        <p class="text-red-400 pr-4">Valor R$ {{ contract.data.amount_invested }}</p>
                        <p class="text-red-400 pr-4">Taxa de Administração {{ contract.data.administration_fee }}%</p>
                        <p class="text-red-400 pr-4" v-if="contract.data.hiring_date == null">Não Aceito</p>
                        <p class="text-red-400 pr-4" v-else>Aceito</p>
                    </div>
                </div>
                
            </router-link>
        </div>
    </div>
  </div>
</template>

<script>
export default {
    name: "ContractsIndex",

    components: {
    },

    mounted() {
        axios.get('/api/contracts')
            .then(response => {
                this.contracts = response.data.data;
                this.searchProducts(response.data.data)
                .then(result=>{
                    console.log(result);
                    this.products = result;
                    this.loading =false;
                })
                .catch(error=>{
                    console.log(error);
                    alert('Não foi possível buscar os produtos associados aos contratos');
                });
            })
            .catch(error=> {
                this.loading = false;

                alert('Não foi possível buscar os contratos');
            });
    },

    data: function () {
        return {
            loading: true,
            products: null,
            contracts: null,
        }
    },

    methods: {
        async searchProducts($contracts) {
            let products = [];
            for(let i = 0; i < $contracts.length; i++){
                await axios.get('/api/financial_products/' + $contracts[i].data.financial_products_id)
                .then(response=> {
                    products[i] = response.data.data;
                })
                .catch(error=>{
                    console.log(error);
                    alert('Problema ao buscar produto associado ao contrato ' + $contracts[i].data.id);
                })
            };
            return products;
        },
    }
}
</script>

<style>

</style>