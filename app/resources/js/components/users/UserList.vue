<template>
    <div class="card">
        <UserFormCreate></UserFormCreate>
        <UserFormEdit @user="(user) => userEdit(user)" :user-edit="userEditEntity"></UserFormEdit>
        <div class="card-body">
            <div class="card-title">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>User list</h5>
                    <button data-toggle="modal"
                            type="button"
                            @click="status='create'"
                            data-target="#modalUserFormCreate"
                            class="btn btn-primary">Add</button>
                </div>
            </div>
            <table class="table">
                <thead>
                <tr>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(user, i) in users" :key="i">
                    <td>
                        {{ user.name }}
                    </td>
                    <td>
                        {{ user.email }}
                    </td>
                    <td>
                        {{ user.created_at}}
                    </td>
                    <td>
                        <button class="btn btn-secondary"
                                data-toggle="modal"
                                data-target="#modalUserFormEdit"
                                @click="() => userToEdit(user, i)">Edit</button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger" @click="() => deleteUser(user.id)">Delete</button>
                    </td>
                </tr>
                </tbody>
            </table>
            <nav v-if="paginate && paginate.totalPages > 1">
                <ul class="pagination">
                    <li :class="['page-item', {disabled: paginate.currentPage === 1}]"
                        @click="() => onPage(paginate.currentPage - 1)">
                        <span class="page-link">Previos</span>
                    </li>
                    <li v-for="i in paginate.totalPages"
                        @click="() => onPage(i)"
                        :class="['page-item', {active: paginate.currentPage === i}]">
                        <span class="page-link">{{ i }}</span>
                    </li>
                    <li :class="['page-item', {disabled: paginate.currentPage === paginate.totalPages}]"
                        @click="() => onPage(paginate.currentPage + 1)"
                    >
                        <span class="page-link">Next</span>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
    import UserFormEdit from "./UserFormEdit";
    import UserFormCreate from "./UserFormCreate";
    import Vue from 'vue';
    export default {
        name: "UserList",
        components: {
            UserFormCreate,
            UserFormEdit
        },
        data() {
            return {
                users: [],
                paginate: null,
                userEditEntity: null,
                userEditKey: null,
                status: 'create'
            };
        },
        mounted() {
            window.axios.get('/users').then(({data}) => {
                this.users = data.users.list;
                this.paginate = data.users.paginate;
            });
        },
        methods: {
            onPage(page) {
                this.users = [];
                window.axios.get(`/users?page=${page}`).then(({data}) => {
                    this.users = data.users.list;
                    this.paginate = data.users.paginate;
                });
            },
            deleteUser(id) {
                window.axios.delete(`/users/${id}`).then(() => {
                    this.users = this.users.filter(item => item.id !== id);
                });
            },
            userToEdit(user, key) {
                this.userEditEntity = user;
                this.userEditKey = key;
            },
            userEdit(user) {
                Vue.set(this.users, this.userEditKey, user);
                this.userEditKey = null;
                this.userEditEntity = null;
            }
        }
    }
</script>

<style scoped>

</style>
