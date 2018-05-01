<template>
    <div>
        <div v-if="signedIn">

                <div class="form-group mt-3">
                    <wysiwyg v-model="body"
                             placeholder="Add a comment?"
                             :id="wysiwygId"
                             :name="wysiwygId"></wysiwyg>
                </div>
                <div class="form-group">
                    <button type="button"
                            class="btn btn-sm btn-primary"
                            @click="addComment">Comment
                    </button>
                </div>

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
                body: ''
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
                axios.post(location.pathname + '/comment', {body: this.body})
                    .catch(error => {
                        flash(error.response.data, 'danger');
                    })
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