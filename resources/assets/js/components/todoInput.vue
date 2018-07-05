<template>
    <div class="box">
        <div class="field is-grouped">
            <p class="control is-expanded">
                <input class="input" type="text" placeholder="Nuevo recordatorio"  
                 v-bind:value="todoItemText"
                 v-on:input="changeText">
            </p>
            <p class="control">
                <a class="button is-info" v-on:click="$emit('addTodo')">
                    Agregar
                </a>
            </p>
        </div>
    </div>
</template>

<script>
export default {
    computed: {
        todoItemText() {
            return this.$store.getters.getTodoItemText;
        }
    },
    methods: {
        changeText(event){
            this.$store.commit('changeText', event);
        }
    }
}
</script>

<style>

</style>
