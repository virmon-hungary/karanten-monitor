<template>
    <div class="radio-list">
        <label :class="['radio', (userValue == value.value ? 'selected' : '')]" :for="value.value" v-for="value in values">
            <span class="radio-label">{{ value.label }}</span>
            <input type="radio"
                   :id="value.value"
                   :name="name"
                   :value="value.value"
                   @click="trigger"
                   v-model="picked">
        </label>
    </div>
</template>

<script>
    export default {
        props: {
            values: Array,
            name: String,
            userValue: String
        },
        data() {
            return {
                picked: null
            }
        },
        mounted() {
            this.picked = this.userValue;
        },
        methods: {
            trigger(event) {
                this.$emit('userInput', event.target.value);
            }
        }
    }
</script>

<style lang="scss">
    .radio-list {
        display: inline-flex;
        flex-direction: column;
    }
    .radio {
        position: relative;
        display: inline-flex;
        padding: 8px 40px 8px 16px;
        align-items: center;
        border: 1px solid #bada55;
        background: rgba(168, 218, 85, .2);

        &.selected {
            background: rgba(168, 218, 85, .5);
            border: 1px solid #617630;

            .radio-label::after {
                position: absolute;
                display: flex;
                content: '✓';
                align-items: center;
                top: 0;
                right: 4px;
                height: 100%;
            }
        }

        &-label {
            display: block;
            width: 100%;
        }

        input { display: none;}
    }
</style>
