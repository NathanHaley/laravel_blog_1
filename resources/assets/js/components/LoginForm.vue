<template>
    <form class="pb-5" @submit.prevent="submitLogin">
        <div v-if="loading" class="text-center h-250 mt-3">
            <div class="text-warning"><i class="fa fa-circle-o-notch fa-spin fa-5x"></i></div>
            <div class="mt-3">Loading...</div>
        </div>
        <div v-else>
            <div class="row">
                <div class="col-sm"></div>
                <div class="col-sm-6 text-center">
                    <div class="form-group">
                        <label for="email" class="sr-only">Email Address</label>
                        <input id="email"
                               type="email"
                               class="form-control"
                               placeholder="Email Address"
                               name="email"
                               v-model="form.email"
                               required
                               autofocus
                               @keydown="form.errors.clear('email')">
                        <transition name="fade">
                            <small id="emailErrors"
                                   class="text-danger"
                                   v-if="form.errors.has('email')">
                                <i class="fa fa-exclamation"></i> Email and/or password not found in our system.
                            </small>
                        </transition>
                    </div>
                </div>
                <div class="col-sm"></div>
            </div>

            <div class="row">
                <div class="col-sm"></div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="password" class="sr-only">Password</label>
                        <div class="">
                            <input id="password"
                                   type="password"
                                   class="form-control"
                                   name="password"
                                   placeholder="Password"
                                   v-model="form.password"
                                   required
                                   @keydown="form.errors.clear('email')">

                        </div>
                    </div>
                </div>
                <div class="col-sm"></div>
            </div>

            <div class="row">
                <div class="col-sm"></div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="checkbox text-center">
                            <label>
                                <input type="checkbox" name="remember" v-model="form.remember"> Remember Me
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-sm"></div>
            </div>

            <div class="row">
                <div class="col-sm"></div>
                <div class="col-sm-6 text-center">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            Login
                        </button>
                        <br>
                        <a class="btn btn-link" href="password/reset">
                            Forgot Your Password?
                        </a>
                    </div>
                </div>
                <div class="col-sm"></div>
            </div>
        </div>
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
                    .then(({data}) => {
                        this.handleSubmit();
                    });
            },

            handleSubmit() {
                this.loading = true;

                setTimeout(function () {
                    location.reload()
                }, 1000);
            }
        }
    }
</script>
