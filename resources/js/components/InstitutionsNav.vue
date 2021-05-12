<template>
    <div>
        <div>
            <p class="pt-12 pl-4 font-bold text-gray-400 text-sm pb-4">Clientes</p>

            <router-link to="/clients/create">
                <p class="pl-8 text-red-300 font-light">Adicionar Cliente</p>
            </router-link>
            
            <router-link to="/clients">
                <p class="pl-8 text-red-300 font-light">Buscar Clientes</p>
            </router-link>
        </div>


        <div>
            <p class="pt-12 pl-4 font-bold text-gray-400 text-sm pb-4">Contas</p>

            <router-link to="/accounts">
                <p class="pl-8 text-red-300 font-light">Buscar Contas</p>
            </router-link>

            <router-link to="/contracts/create">
                <p class="pl-8 text-red-300 font-light">Contratar Produtos</p>
            </router-link>
        </div>


        <div>
            <p class="pt-12 pl-4 font-bold text-gray-400 text-sm pb-4">Produtos Financeiros</p>

            <router-link to="/financial_products/create">
                <p class="pl-8 text-red-300 font-light">Adicionar Produtos</p>
            </router-link>

            <router-link to="/financial_products">
                <p class="pl-8 text-red-300 font-light">Buscar Produtos</p>
            </router-link>        
        </div>


        <div>
            <p class="pt-12 pl-4 font-bold text-gray-400 text-sm pb-4">Compartilhamentos</p>

            <router-link to="/sharings/create">
                <p class="pl-8 text-red-300 font-light">Adicionar Compartilhamento</p>
            </router-link>

            <router-link to="/sharings">
                <p class="pl-8 text-red-300 font-light">Buscar Compartilhamentos</p>
            </router-link>        
        </div>
    </div>

</template>

<script>
export default {
    name:"InstitutionsNav",

    props: {
        'owner' : '',
    }

}
</script>

<style>

</style>