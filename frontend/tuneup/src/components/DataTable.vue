<template>
<div class="overflow-x-auto">
    <table class="table">
        <thead>
            <tr>
                <th v-for="column in columns">{{column}}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="dataInstance in data">
                <td v-for="column in columns">{{ dataInstance[column] }}</td>
            </tr>
        </tbody>
    </table>
</div>
</template>
<script setup lang="ts">

const props = defineProps({
    data: {
        type: Object,
        default: () => {return []}
    },
    columns: {
        type: Array<string>,
        default: () => { return []}
    }
})
</script>