<template>
    <div :id="'comment-'+id" class="card mt-3">
        <div class="card-header d-flex">
            <avatar :username="comment.user.name"
                    :avatar_path="comment.user.avatar_path"></avatar>

            <span class="h5 flex ml-3">
                <a :href="'/profiles/'+comment.user.name"
                   v-text="comment.user.name">
                </a>
                <span class="h5 text-muted small text-nowrap" v-text="ago"></span>
            </span>

            <div class="ml-auto">
                <like-button
                        :path="comment.path"
                        :likes-count="comment.likes_count"
                        :is-liked="comment.isLiked">
                </like-button>
            </div>

        </div>

        <div class="card-body">
            <div v-if="editing">
                <form @submit.prevent="update" @keydown="form.errors.clear()">
                    <div class="form-group">
                        <wysiwyg v-model="form.body" :id="wysiwygId" :name="wysiwygId"></wysiwyg>
                        <small :id="wysiwygId + 'Errors'"
                               class="text-danger border border-danger p-1 rounded"
                               v-if="form.errors.has('body')"
                               v-text="form.errors.get('body')"></small>
                    </div>

                    <button class="btn btn-sm btn-primary"
                            type="submit"
                            :disabled="form.errors.any()">Update</button>

                    <button class="btn btn-sm btn-link"
                            @click="cancelWysiwyg"
                            type="button">Cancel</button>

                </form>
            </div>
            <div v-else v-html="form.body" class="trix-content"></div>
        </div>
        <div class="card-footer level" v-if="this.user != null && comment.user.name == this.user.name">
            <button class="btn btn-sm btn-primary mr-1" @click="editing = true">Edit</button>
            <button class="btn btn-sm btn-danger mr-1" @click="destroy">Delete</button>
        </div>
    </div>
</template>
<script>
    import Like from './LikeButton';
    import moment from 'moment';

    export default {
        props: ['comment'],

        components: {Like},

        data() {
            return {
                editing: false,
                id: this.comment.id,
                body: this.comment.body,
                path: this.comment.path,
                form: new Form({ body: this.comment.body })
            };
        },

        computed: {
            ago() {
                return moment.utc(this.comment.created_at.date).local().fromNow();
            },
            user() {
                return window.App.user;
            },
            wysiwygId() {
                return 'comment' + this.id;
            }
        },

        methods: {

            onSubmit() {
                this.form
                    .post('/comments')
                    .then(status => this.$emit('completed', status));
            },

            cancelWysiwyg() {
                this.form.body = this.comment.body;
                this.editing = false;

            },

            update() {
                var newValue = this.form.body;
                this.form
                    .patch('/comment/' + this.id)
                    .then(({data}) => {
                        this.comment.body = newValue;
                        this.editing = false;

                        flash('Updated!');
                    });
            },

            async destroy() {
                await axios.delete('/comment/' + this.id);

                this.$emit('deleted', this.id);

                flash('Comment removed.', 'danger');
            },
        }
    };
</script>
