<template>
    <form class="pb-5" @submit.prevent="submitRegistration">
        <div v-if="loading" class="text-center h-250 mt-3">
            <div><i class="fa fa-circle-o-notch fa-spin fa-5x"></i></div>
            <div class="mt-3">Loading...</div>
        </div>
        <span v-else>
            <div class="form-group row">
                <label for="name" class="col-sm-4 col-form-label text-md-right">Name</label>

                <div class="col-md-6 text-left">
                    <input id="name"
                           type="name"
                           class="form-control"
                           name="name"
                           v-model="form.name"
                           required
                           autofocus
                           @keydown="form.errors.clear('name')">

                    <small id="nameErrors"
                           class="text-danger"
                           v-if="form.errors.has('name')"
                           v-text="form.errors.get('name')"></small>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-4 col-form-label text-md-right">Email Address</label>

                <div class="col-md-6 text-left">
                    <input id="email"
                           type="email"
                           class="form-control"
                           name="email"
                           v-model="form.email"
                           required
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
                           @keydown="form.errors.clear('password')">
                    <small id="passwordErrors"
                           class="text-danger"
                           v-if="form.errors.has('password')"
                           v-text="form.errors.get('password')"></small>
                </div>
            </div>

            <div class="form-group row">
                <label for="password_confirmation" class="col-sm-4 col-form-label text-md-right">Confirm Password</label>

                <div class="col-md-6">
                    <input id="password_confirmation"
                           type="password"
                           class="form-control"
                           name="password_confirmation"
                           v-model="form.password_confirmation"
                           required
                           @keydown="form.errors.clear('password_confirmation')">
                    <small id="passwordConfirmErrors"
                           class="text-danger"
                           v-if="form.errors.has('password_confirmation')"
                           v-text="form.errors.get('password_confirmation')"></small>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4 text-left">
                    <button type="submit" class="btn btn-primary">
                        Register
                    </button>
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
