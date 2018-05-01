<template>
    <div>

        <create-comment @created="fetch"></create-comment>

        <div v-for="(comment, index) in items" :key="comment.id">
            <comment :comment="comment" @deleted="remove(index)"></comment>
        </div>

        <paginator :dataSet="dataSet" @changed="fetch"></paginator>


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
            }
        },

        created() {
            this.fetch();
        },

        methods: {
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
                this.items = data.data;
                window.scrollTo(0, 0);
            },
        }
    }
</script>

<style scoped>

</style>