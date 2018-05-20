<template>
    <form class="pb-5" @submit.prevent="submitLogin">
        <div v-if="loading" class="text-center h-250 mt-3">
            <div><i class="fa fa-circle-o-notch fa-spin fa-5x"></i></div>
            <div class="mt-3">Loading...</div>
        </div>
        <span v-else>
            <div class="form-group row">
                <label for="email" class="col-sm-4 col-form-label text-md-right">Email Address</label>

                <div class="col-md-6 text-left">
                    <input id="email"
                           type="email"
                           class="form-control"
                           name="email"
                           v-model="form.email"
                           required
                           autofocus
                           @keydown="form.errors.clear('email')">

                    <small id="emailErrors"
                           class="text-danger"
                           v-if="form.errors.has('email')"
                           v-text="'Email and/or password not found in our system.'"></small>
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-sm-4 col-form-label text-md-right">Password <p><small class="text-muted">6 character minimum</small></p></label>

                <div class="col-md-6">
                    <input id="password"
                           type="password"
                           class="form-control"
                           name="password"
                           v-model="form.password"
                           required
                           @keydown="form.errors.clear('email')">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6 offset-md-4">
                    <div class="checkbox text-left">
                        <label>
                            <input type="checkbox" name="remember" v-model="form.remember"> Remember Me
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4 text-left">
                    <button type="submit" class="btn btn-primary">
                        Login
                    </button>

                    <a class="btn btn-link" href="password/reset">
                        Forgot Your Password?
                    </a>
                </div>
            </div>
        </span>
    </form>
</template>

<script>
    export default {

        data() {
            return {
                form: new Form({
                    email: 'demouser@nathanhaley.com',
                    password: 'pass123',
                    remember: null,
                }),
                loading: false
            };
        },

        computed: {
            user() {
                return window.App.user;
            },
        },

        methods: {
            submitLogin() {
                this.form
                    .post('/login')
                    .then(
                        this.handleSubmit()
                    );
            },

            handleSubmit() {

                this.loading = true;
                setTimeout(function () {
                    location.reload()
                }, 1000)
            }
        }
    }
</script>
