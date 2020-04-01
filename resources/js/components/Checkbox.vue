<template>
    <div class="checkbox-list">
        <label :class="['checkbox', (selected.includes(value) ? 'selected' : '')]" :for="value" v-for="value in values">
            <span class="checkbox-label">{{ value }}</span>
            <input type="checkbox"
                   :id="value"
                   :name="name"
                   :value="value"
                   @change="trigger"
                   v-model="selected">
        </label>
    </div>
</template>

<script>
    export default {
        props: {
            values: Array,
            name: String,
            userValue: Array
        },
        data() {
            return {
                selected: []
            }
        },
        mounted() {
            this.selected = this.userValue || [];
        },
        methods: {
            trigger(event) {
                this.$emit('userInput', event.target.value, event.target.checked);
            }
        }
    }
</script>

<style lang="scss">
    .checkbox-list {
        display: inline-flex;
        flex-direction: column;
    }
    .checkbox {
        position: relative;
        display: inline-flex;
        padding: 8px 40px 8px 16px;
        align-items: center;
        border: 1px solid #bada55;
        background: rgba(168, 218, 85, .2);

    &.selected {
        background: rgba(168, 218, 85, .5);
        border: 1px solid #617630;

        .checkbox-label::after {
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
