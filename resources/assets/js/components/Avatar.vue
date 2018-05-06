<template>
    <span>
        <span v-if="isLink === 'yes'">
            <a :href="'/profiles/' + name">
                <img :src="avatar_file"
                     :alt="name"
                     :id="id"
                     :name="name + '_avatar'"
                     :class="classes + ' relative rounded-circle'"
                     :style="'width: ' + size + 'em;'">
            </a>
        </span>
        <span v-else>
            <img :src="avatar_file"
                 :alt="name"
                 :id="id"
                 :name="name + '_avatar'"
                 :class="classes + ' relative rounded-circle'"
                 :style="'width: ' + size + 'em;'">
        </span>
    </span>
</template>

<script>
    export default {
        name: "Avatar",

        props: {
            id: {},
            username: {},
            avatar_path: {},
            width: {
                default: 2,
            },
            classes: {},
            withLink: {
                default: 'yes'
            },
        },

        data() {
            return {
                name: this.username,
                avatar: this.avatar_path,
                size: this.width,
                isLink: this.withLink
            }
        },

        computed: {
            avatar_file() {
                return this.avatar_path;
            },

        },
    }
</script>

<style scoped>

</style>