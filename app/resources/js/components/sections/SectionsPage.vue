<template>
    <div>
        <h3>Sections page</h3>
        <section-list></section-list>
    </div>
</template>

<script>
    import SectionList from "./SectionList";
    export default {
        components: {
            'section-list': SectionList,
        },
        name: "SectionsPage",
        mounted() {
        }
    }
</script>

<style scoped>

</style>
