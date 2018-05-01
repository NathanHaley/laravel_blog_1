<template>
    <div>
        <div>
            <avatar with-link="no" :username="username" :avatar_path="avatar_file"></avatar>
        </div>

        <form method="POST" enctype="multipart/form-data" class="mt-3">
            <image-upload name="avatar" class="mr-1" @loaded="onLoad"></image-upload>
        </form>

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

        components: { ImageUpload },

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
                            $('#nav_avatar').attr('src', data.data[0]);
                            this.avatar_file = data.data[0];
                            flash('Avatar uploaded! Try refreshing page if you don\'t see changes');
                        });
            }
        }
    }
</script>
