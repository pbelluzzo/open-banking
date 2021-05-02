<template>
    <div class="h_screen bg-white">
        <div class="flex">
            <div class="bg-gray-100 w-60 h-screen border-r-2 border-red-200">
                <nav>
                    <router-link to="/">
                    <div class="font-extralight text-red-400 text-3xl h-12 p-2 pb-1">
                        <a href="/" class="hover:text-red-500">open.b</a>
                    </div>
                    </router-link>
                    <div class="w-28 border-b-2 px-2 pt-0"></div>

                    <div  v-if="userIsInstitution()">
                        <p class="pt-12 pl-4 font-bold text-gray-400 text-sm pb-4">Clientes</p>
                        <router-link to="/clients/create">
                            <p class="pl-8 text-red-300 font-light">Adicionar Cliente</p>
                        </router-link>
                        <router-link to="/clients">
                            <p class="pl-8 text-red-300 font-light">Buscar Clientes</p>
                        </router-link>
                    </div>

                    <div  v-if="userIsInstitution()">
                        <p class="pt-12 pl-4 font-bold text-gray-400 text-sm pb-4">Contas</p>
                        <router-link to="/accounts">
                            <p class="pl-8 text-red-300 font-light">Buscar Contas</p>
                        </router-link>
                        <router-link to="/contracts/create">
                            <p class="pl-8 text-red-300 font-light">Contratar Produtos</p>
                        </router-link>
                    </div>

                    <div v-if="userIsInstitution()">
                        <p class="pt-12 pl-4 font-bold text-gray-400 text-sm pb-4">Produtos Financeiros</p>
                        <router-link to="/financial_products/create">
                            <p class="pl-8 text-red-300 font-light">Adicionar Produtos</p>
                        </router-link>
                        <router-link to="/financial_products">
                            <p class="pl-8 text-red-300 font-light">Buscar Produtos</p>
                        </router-link>        
                    </div>

                    <div v-if="userIsInstitution()">
                        <p class="pt-12 pl-4 font-bold text-gray-400 text-sm pb-4">Compartilhamentos</p>
                        <router-link to="/sharings/create">
                            <p class="pl-8 text-red-300 font-light">Adicionar Compartilhamento</p>
                        </router-link>
                        <router-link to="/sharings">
                            <p class="pl-8 text-red-300 font-light">Buscar Compartilhamentos</p>
                        </router-link>        
                    </div>

                    <div>
                        <router-link to="/logout">
                        <p class="pt-12 pl-4 font-bold text-red-400 text-sm pb-4">Logout</p>
                        </router-link>
                    </div>

                </nav>
            </div>
            <div class="flex flex-col flex-1 h-screen overflow-y-hidden">
                <div class="h-16 px-6 border-b border-red-200 flex items-center justify-end">
                    <div class="pr-6">
                        <p v-if="userIsInstitution()" class="font-bold text-gray-400"> {{ owner.fantasy_name}}</p>
                        
                    </div>
                    <UserCircle :name="user.login" />
                </div>
                
                <div class="flex flex-col overflow-y-hidden flex-1">
                    <router-view :user="this.user" class="p-6 overflow-x-hidden"></router-view>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
    import UserCircle from './UserCircle';

    export default {
        name : "App",

        props: [
            'user',
        ],

        components: {
            UserCircle,
        },

        data: function() {
            return {
                'owner': '',
                title: '',
            }
        },

        watch: {
            $route(to, from) {
                this.title = to.meta.title;
            },

            title() {
                document.title = this.title + ' | open.B'
            }
        },

        created() {
            window.axios.interceptors.request.use(
                (config) => {
                    if (config.method === 'get') {
                        config.url = config.url + '?api_token=' + this.user.api_token
                    }else {
                        config.data = {
                        ...config.data,
                        api_token: this.user.api_token
                    };
                    }
                    return config;
                }
            )
            this.getUserOwner();
        },

        methods:{
            userIsInstitution: function() {
                return this.user.entity_type == 'App\\Models\\FinancialInstitutions'
            },

            getUserOwner: function() {
                if(this.userIsInstitution()){
                    console.log('is institution');
                    axios.get('/api/financial_institutions/' + this.user.entity_id)
                    .then(response => {
                        this.owner = response.data.data;        
                    })
                    .catch(error => {
                        this.loading = false;
                    });
                }

                if(/** User is client */ false){
                axios.get('/api/clients/' + this.user.entity_id)
                    .then(response => {
                        this.owner = response.data.data;        
                    })
                    .catch(error => {
                        this.loading = false;
                    });
                }
            }
        },
    }

</script>

<style scoped>

</style>