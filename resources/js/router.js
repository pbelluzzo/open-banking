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
    ]
});