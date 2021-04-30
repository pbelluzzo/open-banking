<template>
    <div class="rounded-full border border-gray-300 text-white bg-red-300 w-10 h-10 flex items-center justify-center uppercase">
        {{userCircle}}
    </div>
</template>

<script>
export default {
    name: "UserCircle",

    props: [
        'name',
    ],

    computed: {
        userCircle: function() {
            return this.name.match(/[a-zA-Z]/g).slice(0,1).join('');
        },
    }
}
</script>

<style>

</style>