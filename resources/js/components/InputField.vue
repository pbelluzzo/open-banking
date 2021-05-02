<template>
    <div class="relative pb-4">
        <label :for="name" class="text-red-300 pt-2 font-bold text-xs uppercase absolute">{{label}}</label>
        
        <the-mask :mask="['###.###.###-##']" v-if="this.name == 'cpf'" :id="name" :type="type" class="pt-8 w-full border-b pb-2 focus:outline-none focus:border-red-400 text-gray-600"
        :placeholder="placeholder" v-model="value" @input="updateField()"/>

        <input v-else :id="name" :type="type" class="pt-8 w-full border-b pb-2 focus:outline-none focus:border-red-400 text-gray-600"
        :placeholder="placeholder" v-model="value" @input="updateField()">

        <p class="text-red-500 text-sm" v-text="errorMessage()">Error</p>
    </div>
</template>

<script>
import {TheMask} from 'vue-the-mask';

export default {
    name:"InputField",

    components: {
        TheMask
    },

    props: [
        'name', 'label', 'placeholder','errors', 'data', 'type'
    ],

    data: function () {
        return {
            value:''
        }
    },

    computed: {
        hasError: function() {
            return this.errors && this.errors[this.name] && this.errors[this.name].length > 0;
        }
    },

    methods: {
        updateField: function(){
            this.clearErrors(this.name);

            this.$emit('update:field', this.value)
        },

        errorMessage: function() {
            if (this.hasError){
                return this.errors[this.name][0];
            }
        },

        clearErrors: function () {
            if (this.hasError){
                this.errors[this.name] = null;
            }
        },

    },

    watch: {
        data: function (val) {
            this.value = val; 
        }
    }
}
</script>

<style scoped>

</style>    