<template>
    <div>
        <input :id="id" type="hidden" :name="name" :value="value">

        <trix-editor class="trix-content" ref="trix" :input="id" :placeholder="placeholder"></trix-editor>
    </div>
</template>

<style lang="scss">
    @import '~trix/dist/trix.css';
</style>

<script>
    import Trix from 'trix';

    export default {
        name: "Wysiwyg",

        props: [
            'id',
            'name',
            'value',
            'placeholder',
        ],

        mounted () {
            this.$refs.trix.addEventListener('trix-change', e => {
                this.$emit('input', e.target.innerHTML);
            });
        }
    }
</script>

<style scoped>
trix-editor {
    min-height: 100px;
}
</style>

