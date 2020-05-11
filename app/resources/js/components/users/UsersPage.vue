<template>
    <div>
        <h3>Users page</h3>
        <user-list></user-list>
    </div>
</template>

<script>
    import UserList from "./UserList";
    export default {
        components: {
            'user-list': UserList,
        },
        name: "UsersPage",
    }
</script>

<style scoped>

</style>
