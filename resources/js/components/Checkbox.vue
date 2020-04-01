<template>
    <div>
        <div v-for="value in values">
            <input type="checkbox" :name="name" :value="value" @change="trigger" :checked="userValue && userValue.includes(value)"> {{ value }}
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            values: Array,
            name: String,
            userValue: Array
        },
        methods: {
            trigger(event) {
                this.$emit('userInput', event.target.value, event.target.checked);
            }
        }
    }
</script>
