<template>
    <div class="relative pb-4">
        <label :for="cpf" class="text-red-300 pt-2 font-bold text-xs uppercase absolute">{{label}}</label>
        <input :id="cpf" type="text" class="pt-8 w-full border-b pb-2 focus:outline-none focus:border-red-400 text-gray-600"
        :placeholder="placeholder" v-model="value" @input="updateField()">
    </div>
</template>

<script>
export default {
    name:"InputField",

    props: [
        'name', 'label', 'placeholder'
    ],

    data: function () {
        return {
            value:''
        }
    },

    methods: {
        updateField: function(){
            this.$emit('update:field', this.value)
        }
    },
}
</script>

<style scoped>

</style>