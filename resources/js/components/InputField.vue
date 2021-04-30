<template>
    <div class="relative pb-4">
        <label :for="cpf" class="text-red-300 pt-2 font-bold text-xs uppercase absolute">{{label}}</label>
        <input :id="cpf" type="text" class="pt-8 w-full border-b pb-2 focus:outline-none focus:border-red-400 text-gray-600"
        :placeholder="placeholder" v-model="value" @input="updateField()">

        <p class="text-red-500 text-sm" v-text="errorMessage()">Error</p>
    </div>
</template>

<script>
export default {
    name:"InputField",

    props: [
        'name', 'label', 'placeholder','errors', 'data'
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