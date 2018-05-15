<template>
    <div>

        <create-comment @created="fetch"></create-comment>

        <paginator :dataSet="dataSet" :totalPages="totalPages" @changed="fetch"></paginator>

        <div v-for="(comment, index) in items" :key="comment.id">
            <comment :comment="comment" @deleted="deleted(index)"></comment>
        </div>

        <paginator :dataSet="dataSet" :totalPages="totalPages" @changed="fetch"></paginator>


    </div>
</template>

<script>
    import Comment from './Comment';
    import CreateComment from './CreateComment';
    import collection from '../mixins/collection';

    export default {
        name: "Comments",

        components: { Comment, CreateComment },

        mixins: [collection],

        data() {
            return {
                dataSet: false,
                totalPages: 1,
                newPageCount: 0,

            }
        },

        created() {
            this.fetch();
        },

        methods: {

            deleted(index) {
                this.items.splice(index, 1);

                this.dataSet.meta.total -= 1;

                this.newPageCount = Math.ceil((this.dataSet.meta.total) / this.dataSet.meta.per_page);

                if (this.totalPages >= this.newPageCount) {
                    this.fetch(this.dataSet.meta.current_page);
                }

            },

            fetch(page) {
                axios.get(this.url(page)).then(this.refresh);
            },

            url(page) {
                if (! page) {
                    let query = location.search.match(/page=(\d+)/);

                    page = query ? query[1] : 1;
                }
                return location.pathname + '/comment?page=' + page;
            },

            refresh({data}) {
                this.dataSet = data;
                this.totalPages = data.meta.last_page;
                this.items = data.data;
            },
        }
    }
</script>

<style scoped>

</style>