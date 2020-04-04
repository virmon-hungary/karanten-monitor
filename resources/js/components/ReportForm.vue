<template>
    <div class="form-wrapper">
        <div class="form-content">
            <div v-if="!completed">
                <transition
                    :name="animation"
                    mode="out-in"
                >
                    <div class="form-question" :key="step">
                        <div class="form-question-image-wrapper">
                            <img :src="currentStep.imageUrl" v-if="currentStep.imageUrl">
                        </div>
                        <p class="form-question-title">{{ currentStep.title }}</p>
                        <p class="form-question-description">{{ currentStep.description }}</p>
                        <component
                            :is="currentFormComponent"
                            :name="currentStep.name"
                            :values="currentStep.values"
                            :userValue="userValues[step]"
                            @userInput="handleUserInput">
                        </component>
                        <div :style="{visibility: showNextStepHint ? 'visible' : 'hidden'}">
                            <button type="button" class="btn btn-primary" @click="nextStep">Következő kérdés</button>
                            <p>Nyomj <strong>Entert ↵</strong> a továbblépéshez</p>
                        </div>
                    </div>
                </transition>
            </div>
            <div v-show="completed">
                <button type="button" @click="submit">Beküldés</button>
            </div>
        </div>
        <div class="form-navigation">
            <button class="btn btn-outline-dark" @click="prevStep" :disabled="!canStepBack">&larr;</button>
            <button class="btn btn-outline-dark" :disabled="!canStep" @click="nextStep">&rarr;</button>
        </div>
    </div>
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
                animation: null,
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
            showNextStepHint() {
              return !((this.form[this.step].type === 'radio' || this.form[this.step].required) && !this.currentValue);
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
        mounted() {
            document.addEventListener('keyup', e => {
                switch (e.key) {
                    case 'Enter' && !(e.shiftKey || e.metaKey):
                    case 'ArrowRight':
                        this.nextStep();
                        break;
                    case 'ArrowLeft':
                        this.prevStep();
                        break;
                }
            });
        },
        methods: {
            handleUserInput(value, meta) {
                switch (this.form[this.step].type) {
                    case 'radio':
                        this.currentValue = value;
                        this.nextStep();
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
                    setTimeout(() => {
                        this.animation = 'next';
                        this.userValues[this.step] = this.currentValue;
                        this.step = this.step + 1;
                        this.currentValue = this.userValues[this.step];
                    }, 0)
                }
            },
            prevStep() {
                if (this.canStepBack) {
                    this.animation = 'prev';
                    this.userValues[this.step] = this.currentValue;
                    this.currentValue = null;
                    this.step = this.step - 1;
                    this.currentValue = this.userValues[this.step];
                }
            },
            submit() {
                axios.post(this.action, this.form.map((item, i) => ({[item.name]: this.userValues[i]})))
            }
        }
    }
</script>

<style lang="scss">
    .form-wrapper {
        width: 100vw;
        height: 100vh;
        overflow-x: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background: url('/img/background.png');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }
    .form-content {
        height: calc(100% - 100px);
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .form-question {
        &-image-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1em;

            img {
                width: 200px;
            }
        }
        &-title {
            font-weight: bold;
            font-size: 2em;
        }
        &-description {
            font-size: 1.4em;
        }
    }
    .next-enter,
    .prev-leave-to{
        transition-delay: .3s;
        transform: translateX(200px);
        opacity: 0;
    }
    .next-enter-to,
    .prev-enter-to {
        transition-delay: .3s;
        transform: translateX(0);
        opacity: 1;
    }
    .next-enter-active,
    .next-leave-active,
    .prev-enter-active,
    .prev-leave-active {
        transition: all .3s ease;
    }
    .prev-enter,
    .next-leave-to {
        transition-delay: .3s;
        transform: translateX(-200px);
        opacity: 0;
    }

</style>
