<template>
    <ul class="pagination mt-3" v-if="shouldPaginate">
        <li :class="toggleDisabled(prevUrl)">
            <a class="page-link" href="#" aria-label="Previous" rel="prev" @click.prevent="page--">
                <span aria-hidden="true">&laquo; Previous</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>
        <li v-for="index in numPages" :class="checkActive(index)"><a class="page-link" @click.prevent="page = index">{{ index }}</a></li>
        <li :class="toggleDisabled(nextUrl)">
            <a class="page-link" href="#" aria-label="Next" rel="next" @click.prevent="page++">
                <span aria-hidden="true">Next &raquo;</span>
                <span class="sr-only">Next</span>
            </a>
        </li>
    </ul>
</template>

<script>
    export default {
        name: "Paginator",

        props: ['dataSet', 'totalPages'],

        data() {
            return {
                page: 0,
                prevUrl: false,
                nextUrl: false,
                numPages: 0,
            }
        },

        watch: {
            dataSet() {
                this.page = this.dataSet.meta.current_page;
                this.prevUrl = this.dataSet.links.prev;
                this.nextUrl = this.dataSet.links.next;
                this.numPages = this.dataSet.meta.last_page;
            },

            totalPages() {
                this.numPages = this.totalPages;
                this.$forceUpdate();
            },

            page() {
                this.broadcast().updateUrl();
            }
        },

        computed: {
            shouldPaginate() {
                return !! this.prevUrl || !! this.nextUrl;
            },

        },

        methods: {

            toggleDisabled(url) {
                return (url) ? 'page-item' : 'page-item disabled';
            },

            checkActive(index) {
                return  (index == this.page) ? 'page-item active': 'page-item';
            },

            broadcast() {
                this.$emit('changed', this.page);

                return this;
            },

            updateUrl() {
                history.pushState(null, null, '?page=' + this.page);
            }
        }
    }
</script>

<style scoped>

</style>