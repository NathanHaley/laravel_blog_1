<template>
    <div id="demo" class="collapse mb-3">
        <div class="h6 text-center text-muted flex">
            Your Notifications
            <i style="cursor: pointer"
               data-toggle="collapse"
               data-target="#demo"
               class="fa fa-chevron-circle-up"></i>
        </div>
        <div  class="p-2 rounded-top border-bottom-0" style="border: 1px solid #e5e5e5">
            <a :href="notification.data.link + '/notification/' + notification.id"
               class="dropdown-item rounded text-muted"
               style="cursor:pointer;"
               v-for="notification in notifications"
               v-text="notification.data.message">
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        name: "UserNotifications",

        data() {
            return {
                notifications: false
            }
        },

        created() {
            axios.get("/notifications")
                .then(response => this.notifications = response.data);
        },

    }
</script>

<style scoped>

</style>