import Vue from "vue";
import VueRouter from "vue-router";
import ExampleComponent from "./components/ExampleComponent";
import ClientsCreate from "./views/ClientsCreate";
import ClientsShow from "./views/ClientsShow";
import ClientsEdit from "./views/ClientsEdit";
import ClientsIndex from "./views/ClientsIndex";
import FinancialProductsIndex from "./views/FinancialProductsIndex";
import FinancialProductsCreate from "./views/FinancialProductsCreate";
import FinancialProductsShow from "./views/FinancialProductsShow";
import FinancialProductsEdit from "./views/FinancialProductsEdit";
import AccountsIndex from "./views/AccountsIndex";
import AccountsShow from "./views/AccountsShow";
import AccountsEdit from "./views/AccountsEdit";
import ContractsCreate from "./views/ContractsCreate";
import ContractsShow from "./views/ContractsShow";
import ContractsIndex from "./views/ContractsIndex";
import SharingsCreate from "./views/SharingsCreate";
import SharingsIndex from "./views/SharingsIndex";
import SharingsShow from "./views/SharingsShow";

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', component: ExampleComponent},

        { path: '/clients', component: ClientsIndex},
        { path: '/clients/create', component: ClientsCreate},
        { path: '/clients/:id', component: ClientsShow},
        { path: '/clients/:id/edit', component: ClientsEdit},

        { path: '/financial_products', component: FinancialProductsIndex},
        { path: '/financial_products/create', component: FinancialProductsCreate},
        { path: '/financial_products/:id', component: FinancialProductsShow},
        { path: '/financial_products/:id/edit', component: FinancialProductsEdit},

        { path: '/accounts', component: AccountsIndex},
        { path: '/accounts/:id', component: AccountsShow},
        { path: '/accounts/:id/edit', component: AccountsEdit},

        
        { path: '/contracts', component: ContractsIndex},
        { path: '/contracts/create', component: ContractsCreate},
        { path: '/contracts/:id', component: ContractsShow},
        
        { path: '/sharings/create', component: SharingsCreate},
        { path: '/sharings', component: SharingsIndex},
        { path: '/sharings/:id', component: SharingsShow},
        
    ]
});