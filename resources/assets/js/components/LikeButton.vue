<template>
    <button :class="classes" @click="toggle">
        <span class="fa fa-heart"></span>
        <span v-text="allLikesCount"></span>
    </button>
</template>
<script>
    export default {
        props: {
            addClasses:{},
            path:{},
            likesCount:{},
            isLiked: {
                type: Boolean
            }

        },

        data() {
            return {
                allLikesCount: this.likesCount,
                userLiked: this.isLiked
            };
        },
        computed: {
            classes() {
                return ['btn', this.userLiked ? 'btn-primary' : 'btn-outline-primary', this.addClasses];
            },
            endpoint() {
                return this.path;// + '/like';
            }
        },
        methods: {
            toggle() {
                return this.userLiked ? this.destroy() : this.create();
            },
            create() {
                axios.post(this.endpoint);

                this.userLiked = true;
                this.allLikesCount++;
            },
            destroy() {
                axios.delete(this.endpoint);

                this.userLiked = false;
                this.allLikesCount--;
            }
        }
    };
</script>
