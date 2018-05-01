<template>
    <div :id="'comment-'+id" class="card mt-3">
        <div class="card-header d-flex">


            <h5 class="flex">
                <a :href="'/profiles/'+comment.user.name" v-text="comment.user.name">
                </a> said <span v-text="ago"></span>
            </h5>
            <div v-if="signedIn" class="ml-auto">
                <like-button
                        :path="comment.path"
                        :likes-count="comment.likes_count"
                        :is-liked="comment.isLiked">
                </like-button>
            </div>

        </div>

        <div class="card-body">
            <div v-if="editing">
                <form>
                    <div class="form-group">
                        <wysiwyg v-model="body" :id="wysiwygId" :name="wysiwygId"></wysiwyg>
                    </div>
                    <button class="btn btn-sm btn-primary" @click="update" type="button">Update</button>
                    <button class="btn btn-sm btn-link" @click="cancelWysiwyg" type="button">Cancel</button>
                </form>
            </div>
            <div v-else v-html="body" class="trix-content"></div>
        </div>
        <div class="card-footer level" v-if="comment.user.id == this.user.id">
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
            };
        },

        computed: {
            ago() {
                return moment(this.comment.created_at).fromNow();
            },
            user() {
                return window.App.user;
            },
            wysiwygId() {
                return 'comment' + this.id;
            }
        },

        methods: {
            cancelWysiwyg() {
                this.body = this.comment.body;
                this.editing = false;

            },

            update() {
                axios.patch(
                    '/comment/' + this.id, {
                        body: this.body
                    })
                    .catch(error => {
                        flash(error.response.data, 'danger');
                    }).then(({data}) => {

                    this.comment.body = this.body;
                    this.editing = false;

                    flash('Updated!');
                });
            },

            destroy() {
                axios.delete('/comment/' + this.id);

                this.$emit('deleted', this.id);
            },
        }
    };
</script>
