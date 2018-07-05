<template>
    <div class="container">
        <todo-input v-bind:todoItemText="todoItemText" v-on:addTodo="addTodo"
         v-on:textChanged="todoItemText = $event"></todo-input>
        <table class="table is-bordered">
            <todo-item
                v-for="(todo, index) in items"
                v-bind:key="index"
                v-bind:id="todo.id"
                v-bind:text="todo.text"
                v-bind:done="todo.done"
                v-on:toggleDone="toggleDone(todo)"
                v-on:removeTodo="removeTodo(todo)"
            ></todo-item>
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
        data () {
            return {
                todoItemText: '',
                items: [],
            }
        },
        mounted () {
            this.listTodos();
        },
        methods: {
            listTodos(){
                axios.get('api/todos').then(response => {
                    this.items = response.data
                });
            },

            addTodo () {
                let text = this.todoItemText.trim();
                if (text !== '') {
                    let todo = {text: text, done: 0};
                    axios.post('api/todos', todo)
                    .then(response => {
                        this.items.push(response.data);
                    })
                    .catch(err => console.log(err));
                    this.todoItemText = '';
                }
            },

            removeTodo (todo) {
                 axios.delete(`api/todos/${todo.id}`).then(response => {
                    this.items = this.items.filter(item => item !== todo);
                }).catch(err => console.log(err));
            },

            toggleDone (todo) {
                axios.put(`api/todos/${todo.id}`,todo).then(response =>{
                    todo.done = !todo.done
                }).catch(err => console.log(err));                
            }
        }
    }
</script>

<style>
    .is-done {
        text-decoration: line-through;
    }
</style>
