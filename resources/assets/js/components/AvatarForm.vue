<template>
    <div class="bg-light rounded">
        <form method="POST" enctype="multipart/form-data" class="form-inline">
            <div class="form-group mb-2">

                <label class="p-2"
                       for="inputAvatar">

                    <avatar with-link="no"
                            :username="username"
                            :avatar_path="avatar_file">
                    </avatar>

                </label>

                <image-upload name="avatar"
                              id="inputAvatar"
                              class="form-control mr-1 border-0 bg-light"
                              @loaded="onLoad">
                </image-upload>

            </div>
        </form>
        <small id="inputAvatarHelp" class="form-text text-muted p-2">
            Must be an image file, jpg/jpeg/png, and less than 10kb.
        </small>
    </div>
</template>

<script>
    import ImageUpload from './ImageUpload';

    export default {
        props: ['username', 'avatar_path', 'withLink'],

        data() {
            return {
                avatar_file: this.avatar_path,
            }
        },
        // computed: {
        //     avatar_file(new_path = false) {
        //         return new_path ? new_path : this.avatar_path;
        //     }
        // },

        components: {ImageUpload},

        methods: {
            onLoad(avatar) {
                this.avatar = avatar.src;

                this.persist(avatar.file);
            },

            persist(avatar) {
                let data = new FormData();

                data.append('avatar', avatar);

                axios.post(`/api/users/${this.username}/avatar`, data)
                    .then(
                        (data) => {
                            //Update avatar in the nav
                            $('#nav_avatar').attr('src', data.data[0]);

                            this.avatar_file = data.data[0];

                            flash('Avatar uploaded! Try refreshing page if you don\'t see changes');
                        });
            }
        }
    }
</script>
