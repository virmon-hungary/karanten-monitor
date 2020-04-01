<template>
    <div>
        <textarea type="radio" :name="name" @keyup="trigger" :value="userValue"></textarea>
    </div>
</template>

<script>
    export default {
        props: {
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
