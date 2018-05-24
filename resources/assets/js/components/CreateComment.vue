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
            <sweet-modal ref="modalLoginPrompt" title="<center style='font-family: Arial' class='mt-3'>Please login or register to participate</center>">

                <sweet-modal-tab title="Login" id="tab1">
                    <p class="h4 text-center mb-3">Login</p>
                    <login-form></login-form>
                </sweet-modal-tab>

                <sweet-modal-tab title="Register" id="tab2">
                    <p class="h4 text-center mb-3">Register</p>
                    <registration-form></registration-form>
                </sweet-modal-tab>

            </sweet-modal>

            <p class="text-center">Please <button class="btn btn-link p-0 pb-1" @click="$refs.modalLoginPrompt.open()">sign in</button> to participate.</p>

        </div>
    </div>
</template>

<script>

    export default {
        name: "CreateComment",

        props: {
            path: {},
        },

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
                    .post(this.path + '/show/comment')
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