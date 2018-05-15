<template>
    <div>
        <div v-if="signedIn">
            <form @submit.prevent="addComment" @keydown="form.errors.clear()">

                <div class="form-group mt-3">
                    <wysiwyg v-model="form.body"
                             placeholder="Add a comment?"
                             :id="wysiwygId"
                             :name="wysiwygId"></wysiwyg>
                    <small :id="wysiwygId + 'Errors'"
                           class="text-danger border border-danger p-1 rounded"
                            v-if="form.errors.has('body')"
                           v-text="form.errors.get('body')"></small>

                </div>
                <div class="form-group">
                    <button type="submit"
                            class="btn btn-sm btn-primary"
                            :disabled="form.errors.any()">Comment
                    </button>
                </div>
            </form>
        </div>
        <div v-else>
            <p class="text-center">Please <a href="/login">sign in</a> to participate.</p>
        </div>
    </div>
</template>

<script>

    export default {
        name: "CreateComment",

        data() {
            return {
                body: '',
                form: new Form({ body: '' })
            };
        },

        computed: {
            wysiwygId() {
                return 'commentNull';
            },
            element() {
                return document.querySelector("trix-editor");
            }
        },

        methods: {
            addComment() {

                this.form
                    .post(location.pathname + '/comment')
                    .then(({data}) => {
                        this.element.reset();

                        flash('Your comment has been added.');

                        this.$emit('created', data);
                    });

            }
        }
    }
</script>

<style scoped>

</style>