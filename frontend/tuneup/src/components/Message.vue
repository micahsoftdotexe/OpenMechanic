<template>
    <div>
        <article class="message" :class="headerClass()">
            <div class="message-header">
                <p>{{messageHeader}}</p>
            </div>
            <div class="message-body">
                <p>{{messageText}}</p>
            </div>
        </article>
    </div>
</template>
<script lang="ts" setup>

const props = defineProps({
    messageType: {
        type: String,
        required: true
    },
    messageHeader: {
        type: String,
        required: true
    },
    messageText: {
        type: String,
        required: true
    }
})
function headerClass() {
    if (props.messageType == 'Error') {
        return 'is-danger'
    } else {
        return 'is-success'
    }
}
</script>