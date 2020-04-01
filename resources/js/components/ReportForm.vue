<template>
    <form>
        <div v-if="!completed">
            {{ form[step].title }}
            <component
                :is="currentFormComponent"
                :name="currentStep.name"
                :values="currentStep.values"
                :userValue="userValues[step]"
                @userInput="handleUserInput">
            </component>
            <button type="button" @click="prevStep" :disabled="!canStepBack"><</button>
            <button type="button" :disabled="!canStep" @click="nextStep">></button>
        </div>
        <div v-show="completed">
            <button type="button" @click="submit">Beküldés</button>
        </div>
    </form>
</template>

<script>
    import axios from 'axios';
    import Radio from "./Radio";
    import Checkbox from "./Checkbox";
    import Textarea from "./Textarea";

    export default {
        name: 'ReportForm',
        props: {
            form: Array,
            action: String,
            csrf: String
        },
        data() {
            return {
                step: 0,
                currentValue: null,
                userValues: []
            }
        },
        computed: {
            completed() {
                return this.step == this.form.length;
            },
            currentStep() {
                return this.form[this.step];
            },
            currentFormComponent() {
                switch (this.form[this.step].type) {
                    case 'radio': return 'Radio';
                    case 'checkbox': return 'Checkbox';
                    case 'textarea': return 'Textarea';
                }
            },
            canStep() {
                if (this.currentStep.required && !this.currentValue) {
                    return false;
                }
                return this.currentValue || !this.currentStep.required;
            },
            canStepBack() {
                return this.step > 0;
            }
        },
        methods: {
            handleUserInput(value, meta) {
                switch (this.form[this.step].type) {
                    case 'radio':
                        this.currentValue = value;
                        break;
                    case 'checkbox':
                        let current = this.currentValue;
                        if (Array.isArray(current)) {
                            meta
                                ? current.push(value)
                                : current.splice(current.indexOf(value), 1);
                        }
                        else {
                            current = [value];
                        }

                        if (current.length === 0) {
                            current = null;
                        }

                        this.currentValue = current;
                        break;
                    case 'textarea':
                        this.currentValue = value;
                        break;
                }
            },
            nextStep() {
                if (this.canStep) {
                    this.userValues[this.step] = this.currentValue;
                    this.step = this.step + 1;
                    this.currentValue = this.userValues[this.step];
                }
            },
            prevStep() {
                this.userValues[this.step] = this.currentValue;
                this.currentValue = null;
                this.step = this.step - 1;
                this.currentValue = this.userValues[this.step];
            },
            submit() {
                axios.post(this.action, this.form.map((item, i) => ({[item.name]: this.userValues[i]})))
            }
        }
    }
</script>
