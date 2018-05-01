<template>
    <button :class="classes" @click="follow">{{label}}</button>
</template>

<script>
    export default {
        name: "FollowButton",

        props: ['active', 'userId'],

        data() {
            return {
                isActive: this.active,
            }
        },

        computed: {
            classes() {
                return['btn btn-xs', this.isActive ? 'btn-primary' : 'btn-outline-primary']
            },
            label() {
                return this.isActive ? 'Unfollow' : 'Follow'
            }
        },

        methods: {
            follow() {
                axios[
                    (this.isActive ? 'delete' : 'post')
                    ]('/follow/' + this.userId);

                this.isActive = !this.isActive;

            }
        }
    }
</script>

<style scoped>

</style>