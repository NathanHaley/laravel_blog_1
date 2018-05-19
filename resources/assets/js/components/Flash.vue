<template>
    <div class="alert"
         :class="'alert-' + level"
         role="alert"
         v-show="show"
        v-text="body"
        :style="'z-index: 99; position: fixed; right: ' + this.fromRight + 'px; top: ' + this.fromTop + 'px;'"
        >
    </div>
</template>

<script>
    export default {
        props: {
            message: {},
            type: {},
            right: {
                default: 25
            },
            top: {
                default: 25
            }
        },

        data() {
            return {
                body: this.message,
                level: this.type,
                fromRight: this.right,
                fromTop: this.top,
                show: false
            };
        },
        created() {
            if (this.message) {
                this.flash();
            }

            window.events.$on('flash', data =>  this.flash(data));
        },

        methods: {
            flash(data) {
                if(data) {
                    this.body = data.message;
                    this.level = data.level;
                    this.fromRight = data.right;
                    this.fromTop = data.top;
                }

                this.show = true;

                this.hide();
            },
            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 2000);
            }
        }
    };
</script>

<style>
</style>