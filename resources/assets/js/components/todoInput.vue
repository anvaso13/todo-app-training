<template>
    <form v-on:submit.prevent="$emit('addTodo')">
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
    </form>
</template>

<script>
export default {
    props:['todoItemText'],
    data () {
        return {
            inputText: ''
        }
    },
    methods: {
        changeText(event){
            this.inputText = event.target.value;
            this.$emit('textChanged',this.inputText);
        }
    }
}
</script>

<style>

</style>
