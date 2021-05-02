<template>
  <div>
    <div v-if="loading">Carregando...</div>
    <div v-else>
        <div v-if="contracts.length === 0">
            <p>Não existem contratos cadastrados.</p>
        </div>

        <div v-for="contract in contracts" :key="contract.id">
            <router-link :to="'/contracts/' + contract.data.id" class="flex items-center border-b border-gray-400 p-4 hover:bg-red-100 hover:no-underline">
                
                <div class="pl-3">
                    <p class="font-bold text-gray-400">Contrato Nº {{ contract.data.id }}</p>
                    <div class="flex pt-4">
                        <p class="text-red-400 pr-4">Valor R$ {{ contract.data.amount_invested }}</p>
                        <p class="text-red-400 pr-4">Taxa de Administração {{ contract.data.administration_fee }}%</p>
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
                this.loading = false;
            })
            .catch(error=> {
                this.loading = false;

                alert('Não foi possível buscar os contratos');
            });
    },

    data: function () {
        return {
            loading: true,
            contracts: null,
        }
    },

    methods: {
    }
}
</script>

<style>

</style>