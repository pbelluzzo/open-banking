<template>
    <div>
        <div v-if="loading">Carregando...</div>
        <div v-else>
            <div class="flex justify-between">
                <a href="#" class="text-red-300" @click="$router.back()">
                    Voltar
                </a>
                <div>
                    <router-link :to="'/clients/' + client.id + '/edit'" class="px-4 py-2 rounded text-sm text-green-500
                    border-2 border-green-500 font-bold mr-2 no-underline">Editar</router-link>
                    <a href="#" class="px-4 py-2 rounded text-sm text-red-500 border-2 border-red-500 font-bold no-underline">Deletar</a>
                </div>
            </div>

            <div class="flex items-center pt-6">
                <UserCircle :name="client.name"/>
                <p class="pl-4 text-xl">{{client.name}}</p>
            </div>

            <p class="pt-8 text-gray-400 font-bold uppercase font-xs">CPF</p>
            <p class="pt-2 text-red-300 pl-4">{{ client.cpf }}</p>
            <p class="pt-8 text-gray-400 font-bold uppercase font-xs">Endereço</p>
            <p class="pt-2 text-red-300 pl-4">{{ client.address}}</p>
            <p class="pt-8 text-gray-400 font-bold uppercase font-xs">Data de Nascimento</p>
            <p class="pt-2 text-red-300 pl-4">{{ client.birthdate }}</p>
        </div>            

    </div>
</template>

<script>
import UserCircle from '../components/UserCircle';
export default {
    name: "ClientsShow",

    components: {
        UserCircle,
    },

    mounted() {
        axios.get('/api/clients/' + this.$route.params.id)
        .then(response => {
            this.client = response.data.data;

            this.loading = false;
        })
        .catch(error => {
            this.loading = false;

            if (error.response.status === 404) {
                this.$router.push('/clients');
            }
        });
    },

    data: function() {
        return {
            loading: true,
            client: null,
        }
    }
}
</script>

<style>

</style>