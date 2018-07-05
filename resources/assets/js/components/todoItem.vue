<template>
    <tr>
        <td class="is-fullwidth" style="cursor: pointer" :class="{ 'is-done': done }"
            v-on:click="$emit('toggleDone', id)">
            {{ text }}
        </td>
        <td class="is-narrow">
            <a class="button is-danger is-small" v-on:click="$emit('removeTodo', id)">Eliminar</a>
        </td>
    </tr>
</template>

<script>
export default {
    props: {
        id: Number,
        text: String,
        done: Boolean
    }
}
</script>

<style>

</style>
