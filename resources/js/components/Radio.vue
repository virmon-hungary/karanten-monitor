<template>
    <div>
        <div v-for="value in values">
            <input type="radio" :name="name" :value="value.value" @click="trigger" :checked="value.value == userValue"> {{ value.label }}
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            values: Array,
            name: String,
            userValue: String
        },
        methods: {
            trigger(event) {
                this.$emit('userInput', event.target.value);
            }
        }
    }
</script>
