<template>
    <div class="textarea-wrappper">
        <textarea
            class="textarea"
            type="radio"
            :name="name"
            @keyup="trigger"
            ref="input"
            v-model="value"
            rows="1"
            placeholder="Ide írd a válaszod...">
        </textarea>
        <p>Nyomj Shift ⇧ + Entert ↵ a sortöréshez</p>
    </div>
</template>

<script>
    export default {
        props: {
            name: String,
            userValue: String
        },
        data() {
            return {
                value: ''
            }
        },
        mounted() {
            this.value = this.userValue || '';

            this.$refs.input.focus();
            this.$nextTick(() => {
                console.log(this.$refs.input.scrollHeight)
                this.$refs.input.style.height = this.$refs.input.scrollHeight+'px';
            });
            this.$refs.input.addEventListener('input', this.resizeTextarea);
            this.$refs.input.addEventListener('keydown', this.handleEnter);
        },
        beforeDestroy () {
            this.$refs.input.removeEventListener('input', this.resizeTextarea);
            this.$refs.input.removeEventListener('keydown', this.handleEnter);
        },
        methods: {
            trigger(event) {
                this.$emit('userInput', event.target.value);
            },
            resizeTextarea(event) {
                event.target.style.height = 'auto';
                event.target.style.height = (event.target.scrollHeight) + 'px';
            },
            handleEnter(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    if (event.shiftKey || event.metaKey) {
                        this.value = this.value + '\n';
                        const lineHeight = parseInt(getComputedStyle(this.$refs.input).getPropertyValue('line-height'));
                        this.$refs.input.style.height = this.$refs.input.scrollHeight + lineHeight + 'px';
                    }
                }
            }
        }
    }
</script>

<style lang="scss">
    .textarea-wrappper {
        margin: 2em 0;
    }
    .textarea {
        display: block;
        background-color: transparent;
        border: none;
        resize: none;
        outline: none;
        width: 100%;
        font-size: 1.5em;
        border-bottom: 1px solid gray;
        line-height: 32px;
    }
</style>
