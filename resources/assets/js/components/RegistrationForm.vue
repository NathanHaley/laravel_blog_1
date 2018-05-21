<template>
    <form class="pb-5" @submit.prevent="submitRegistration">
        <div v-if="loading" class="text-center h-250 mt-3">
            <div class="text-warning"><i class="fa fa-circle-o-notch fa-spin fa-5x"></i></div>
            <div class="mt-3">Loading...</div>
        </div>
        <div v-else>
            <div class="row">
                <div class="col-sm"></div>
                <div class="col-sm-6 text-center">
                    <div class="form-group">
                        <label for="name" class="sr-only">Name</label>
                        <input id="name"
                               type="name"
                               class="form-control"
                               name="name"
                               placeholder="Name"
                               v-model="form.name"
                               required
                               autofocus
                               @keydown="form.errors.clear('name')">
                        <transition name="fade">
                            <small id="nameErrors"
                                   class="text-danger"
                                   v-if="form.errors.has('name')">
                                <i class="fa fa-exclamation"></i>
                                <span v-text="form.errors.get('name')"></span>
                            </small>
                        </transition>
                    </div>
                </div>
                <div class="col-sm"></div>
            </div>
            <div class="row">
                <div class="col-sm"></div>
                <div class="col-sm-6 text-center">
                    <div class="form-group">
                        <label for="email" class="sr-only">Email Address</label>
                        <input id="email"
                               type="email"
                               class="form-control"
                               name="email"
                               placeholder="Email Address"
                               v-model="form.email"
                               required
                               @keydown="form.errors.clear('email')">
                        <transition name="fade">
                            <small id="emailErrors"
                                   class="text-danger"
                                   v-if="form.errors.has('email')">
                                <i class="fa fa-exclamation"></i>
                                <span v-text="form.errors.get('email')"></span>
                            </small>
                        </transition>
                    </div>
                </div>
                <div class="col-sm"></div>
            </div>
            <div class="row">
                <div class="col-sm"></div>
                <div class="col-sm-6 text-center">
                    <div class="form-group">
                        <label for="password" class="sr-only">Password
                        </label>
                        <input id="password"
                               type="password"
                               class="form-control"
                               name="password"
                               placeholder="Password"
                               v-model="form.password"
                               required
                               @keydown="form.errors.clear('password')">
                        <transition name="fade" mode="out-in">
                            <small key="error" id="passwordErrors"
                                   class="text-danger"
                                   v-if="form.errors.has('password')">
                                <i class="fa fa-exclamation"></i>
                                <span v-text="form.errors.get('password')"></span>
                            </small>
                            <small key="info" v-else class="text-muted">6 character minimum</small>
                        </transition>
                    </div>
                </div>
                <div class="col-sm"></div>
            </div>
            <div class="row">
                <div class="col-sm"></div>
                <div class="col-sm-6 text-center">
                    <div class="form-group">
                        <label for="password_confirmation" class="sr-only">Confirm
                            Password</label>
                        <input id="password_confirmation"
                               type="password"
                               class="form-control"
                               name="password_confirmation"
                               placeholder="Confirm Password"
                               v-model="form.password_confirmation"
                               required
                               @keydown="form.errors.clear('password_confirmation')">
                        <transition name="fade">
                            <small id="passwordConfirmErrors"
                                   class="text-danger"
                                   v-if="form.errors.has('password_confirmation')">
                                <i class="fa fa-exclamation"></i>
                                <span v-text="form.errors.get('password_confirmation')"></span>
                            </small>
                        </transition>
                    </div>
                </div>
                <div class="col-sm"></div>
            </div>
            <div class="row">
                <div class="col-sm"></div>
                <div class="col-sm-6 text-center">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary w-100">
                            Register
                        </button>
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
                    name: null,
                    email: null,
                    password: null,
                    password_confirmation: null
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
            submitRegistration() {
                this.form
                    .post('/register')
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
<style>

</style>
