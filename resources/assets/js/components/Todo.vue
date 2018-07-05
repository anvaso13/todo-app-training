<template>
    <div class="container">
        <todo-input v-on:addTodo="addTodo()"></todo-input>
        <table class="table is-bordered">
            <todo-item
                v-for="(todo, index) in items"
                v-bind:key="index"
                v-bind:id="todo.id"
                v-bind:text="todo.text"
                v-bind:done="todo.done"
                v-on:toggleDone="toggleDone(todo.id)"
                v-on:removeTodo="removeTodo(todo.id)">
            </todo-item>
        </table>
    </div>
</template>

<script>
    /**
     * Tips:
     * - En mounted pueden obtener el listado del backend de todos y dentro de la promesa de axios asirnarlo
     *   al arreglo que debe tener una estructura similar a los datos de ejemplo.
     * - En addTodo, removeTodo y toggleTodo deben hacer los cambios pertinentes para que las modificaciones,
     *   addiciones o elimicaiones tomen efecto en el backend asi como la base de datos.
     */

    import todoItem from './TodoItem.vue';
    import todoInput from './TodoInput.vue';

    export default {
        components:{
            'todo-input' : todoInput,
            'todo-item' : todoItem
        },
        computed: {
            items(){
                return this.$store.getters.getItems;
            }
        },
        mounted () {
            this.$store.commit('listTodos'); //reemplaza a this.listTodos();
        },

        methods: {
            addTodo() {
                this.$store.dispatch('addTodo');
            },

            removeTodo(id){
                this.$store.dispatch('removeTodo', id);
            },

            toggleDone(id){
                this.$store.dispatch('toggleDone', id);
            }
        }
        
    }
</script>

<style>
    .is-done {
        text-decoration: line-through;
    }
</style>
