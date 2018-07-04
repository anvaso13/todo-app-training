<template>
    <div class="container">
        <form v-on:submit.prevent="addTodo()">
            <div class="box">
                <div class="field is-grouped">
                    <p class="control is-expanded">
                        <input class="input" type="text" placeholder="Nuevo recordatorio" v-model="todoItemText">
                    </p>
                    <p class="control">
                        <a class="button is-info" @click.prevent="addTodo">
                            Agregar
                        </a>
                    </p>
                </div>
             </div>
        </form>
        <table class="table is-bordered">
            <tr v-for="(todo, index) in items" :key="index">
                <td class="is-fullwidth" style="cursor: pointer" :class="{ 'is-done': todo.done }"
                 @click="toggleDone(todo)">
                    {{ todo.text }}
                </td>
                <td class="is-narrow">
                    <a class="button is-danger is-small" @click="removeTodo(todo)">Eliminar</a>
                </td>
            </tr>
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
    export default {
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
