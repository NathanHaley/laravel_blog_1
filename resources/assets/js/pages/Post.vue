<template>
    
</template>

<script>
    import Comments from '../components/Comments';
    import FollowButton from '../components/FollowButton';

    export default {
        name: "Post",

        props: ['post'],
        components: { Comments, FollowButton },

        data() {
            return {
                commentsCount: this.post.comments_count,
                locked: this.post.locked,
                editing: false,
                title: this.post.title,
                channel: this.post.channel,
                lede: this.post.lede,
                body: this.post.body,
                form: {}
            };
        },

        created () {
            this.resetForm();
        },

        methods: {

            update () {
                let uri = `${this.post.path}`;

                axios.patch(uri, this.form).then(() => {
                    this.title = this.form.title;
                    this.channel = this.form.channel;
                    this.lede = this.form.lede;
                    this.body = this.form.body;
                    this.editing = false;

                    flash('Post updated!');
                });
            },

            resetForm () {
                this.form = {
                    title: this.post.title,
                    channel: this.post.channel,
                    lede: this.post.lede,
                    body: this.post.body
                };

                this.editing = false;
            }
        }
    }
</script>

<style scoped>

</style>