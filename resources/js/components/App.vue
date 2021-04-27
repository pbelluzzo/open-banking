<template>
    <div class="h_screen bg-white">
        <div class="flex">
            <div class="bg-gray-100 w-48 h-screen border-r-2 border-red-200">
                <nav>
                    <router-link to="/">
                    <div class="font-extralight text-red-400 text-3xl h-12 p-2 pb-1">
                        <a href="/" class="hover:text-red-500">open.b</a>
                    </div>
                    </router-link>
                    <div class="w-28 border-b-2 px-2 pt-0"></div>

                    <p class="pt-12 pl-4 font-bold text-gray-400 text-sm pb-4">Clientes</p>
                    <router-link to="/clients/create">
                        <p class="pl-8 text-red-300 font-light">Adicionar Cliente</p>
                    </router-link>
                    <router-link to="/">
                        <p class="pl-8 text-red-300 font-light">Buscar Cliente</p>
                    </router-link>

                    <p class="pt-12 pl-4 font-bold text-gray-400 text-sm pb-4">Produtos</p>
                    <router-link to="/">
                        <p class="pl-8 text-red-300 font-light">Adicionar Produtos</p>
                    </router-link>
                    <router-link to="/">
                        <p class="pl-8 text-red-300 font-light">Buscar Produtos</p>
                    </router-link>

                </nav>
            </div>
            <div class="flex flex-col flex-1 h-screen overflow-y-hidden">
                <div class="h-16 px-6 border-b border-red-200 flex items-center justify-between">
                    <div>
                        Test Institution
                    </div>
                    <div class="rounded-full border border-gray-300 text-white bg-red-300 w-10 h-10 flex items-center justify-center">
                        TI
                    </div>
                </div>
                
                <div class="flex flex-col overflow-y-hidden flex-1">
                    <router-view class="p-6 overflow-x-hidden"></router-view>
                </div>
            </div>
        </div>


    </div>
</template>

<script>

    export default {
        name : "App"
    }

</script>

<style scoped>

</style>