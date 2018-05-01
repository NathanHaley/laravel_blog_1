export default {
    data() {
        return {
            items: []
        }
    },
    methods: {
        add(comment) {
            this.items.unshift(comment);

            this.$emit('added');
        },
        remove(index) {
            this.items.splice(index, 1);

            flash('removed');
        }
    }
}