<template>
    <div>
        <p class="pt-12 pl-4 font-bold text-gray-400 text-sm pb-4">Menu</p>

        <router-link to="/accounts">
            <p class="pl-8 text-red-300 font-light">Contas Bancárias</p>
        </router-link>
        <router-link to="/contracts">
            <p class="pl-8 text-red-300 font-light">Contratos</p>
        </router-link>
        <router-link to="/sharings">
            <p class="pl-8 text-red-300 font-light">Compartilhamentos de Dados</p>
        </router-link>
    </div>

</template>

<script>
export default {
    name:"ClientsNav",

    props: {
        'owner' : '',
    }

}
</script>

<style>

</style>