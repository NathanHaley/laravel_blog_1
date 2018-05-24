<template>
    <div id="demo" class="collapse mb-3">
        <div class="h6 text-center text-muted flex">
            Your Notifications <i data-toggle="collapse" data-target="#demo" class="fa fa-close"></i>
        </div>
        <div  class="p-2 rounded-top border-bottom-0" style="border: 1px solid #e5e5e5">
            <a class="dropdown-item rounded text-muted" style="cursor:pointer;" v-for="notification in notifications">
                <avatar with-link="no"
                        :username="this.username"
                        :avatar_path="this.avatar_path">
                </avatar>
                <span
                        :href="notification.data.link"
                        v-text="notification.data.message"
                        @click="markAsRead(notification)"
                ></span>
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        name: "UserNotifications",

        data() {
            return {
                notifications: false,
                username: window.App.user.name,
                avatar_path: window.App.user.path
            }
        },

        created() {
            axios.get("/notifications")
                .then(response => this.notifications = response.data);
        },

        methods: {
            markAsRead(notification) {
                axios.delete("/notifications/" + notification.id);
            }
        }
    }
</script>

<style scoped>

</style>