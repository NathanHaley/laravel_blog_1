<template>
    <div>

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

        <button :class="classes" @click="toggle" style="border:0;">
            <span class="fa fa-heart"></span>
            <span v-text="allLikesCount"></span>
        </button>

    </div>
</template>
<script>
    export default {
        props: {
            path: {},
            likesCount: {},
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
                return [
                    'btn rounded-circle',
                    this.userLiked ?
                        'btn-primary' :
                        'btn-outline-primary',
                    !window.App.signedIn ? 'disabled' : ''
                ];
            },
            endpoint() {
                return this.path + '/like';
            }
        },
        methods: {
            toggle(event) {
                if (window.App.signedIn === false) {
                    this.$refs.modalLoginPrompt.open();

                    return;
                }

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
