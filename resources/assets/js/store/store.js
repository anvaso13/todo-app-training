import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        todoItemText: '',
        items: []
    },

    getters:{
        getItems(state){
            return state.items;
        },
        getTodoItemText(state){
            return state.todoItemText;
        }
    },

    mutations:{
        listTodos(state){
            axios.get('api/todos').then(response => {
                state.items = response.data
            });
        },

        addTodo(state){
            let text = state.todoItemText.trim();
            if (text !== '') {
                let todo = {text: text, done: 0};
                axios.post('api/todos', todo)
                .then(response => {
                    state.items.push(response.data);
                })
                .catch(err => console.log(err));
                state.todoItemText = '';
            }
        },

        changeText(state, event){
            state.todoItemText = event.target.value;
        },

        removeTodo(state, id){
            axios.delete(`api/todos/${id}`).then(response => {
                state.items = state.items.filter(item => item.id !== id);
            }).catch(err => console.log(err));
        },

        toggleDone(state, id){
            //busca primero el item en estado items para mandar el objeto 'todo' al PUT
            let todo = state.items.find(item => {
                return item.id == id;
            });
            axios.put(`api/todos/${id}`,todo).then(response =>{
                todo.done = !todo.done
            }).catch(err => console.log(err)); 
        }
    },

    actions: {
        addTodo(context){
            context.commit('addTodo');
        },
        
        changeText(context, event){
            context.commit('changeText', event);
        },

        removeTodo(context, id){
            context.commit('removeTodo', id);
        },

        toggleDone(context, id){
            context.commit('toggleDone', id);
        }
    }
});
