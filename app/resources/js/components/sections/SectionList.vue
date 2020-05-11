<template>
    <div class="card-body">
        <SectionFormEdit :users="users" @section="(section) => sectionEdit(section)" :section-edit="sectionEditEntity"></SectionFormEdit>
        <SectionFormCreate :users="users"></SectionFormCreate>
        <div class="card-title">
            <div class="d-flex justify-content-between align-items-center">
                <h5>Section list</h5>
                <button data-toggle="modal"
                        type="button"
                        @click="status='create'"
                        data-target="#modalSectionFormCreate"
                        class="btn btn-primary">Add
                </button>
            </div>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th style="width: 10%;"></th>
                <th style="width: 40%;"></th>
                <th style="width: 30%;"></th>
                <th style="width: 10%;"></th>
                <th style="width: 10%;"></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(section, i) in sections" :key="i">
                <td>
                    <img alt="logo" :src="section.logo" />
                </td>
                <td>
                    <div class="card">
                        <div class="card-body">
                            <h5>{{ section.name }}</h5>
                            <p class="card-text">{{ section.description }}</p>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Users:</h5>
                            <ol>
                                <li v-for="user in section.users">
                                    {{ user.name }}
                                </li>
                            </ol>
                        </div>
                    </div>
                </td>
                <td>
                    <button class="btn btn-secondary"
                            data-toggle="modal"
                            data-target="#modalSectionFormEdit"
                            @click="() => sectionToEdit(section, i)">Edit
                    </button>
                </td>
                <td>
                    <button type="button" class="btn btn-danger" @click="() => deleteSection(section.id)">Delete</button>
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
</template>

<script>
    import SectionFormCreate from "./SectionFormCreate";
    import SectionFormEdit from "./SectionFormEdit";
    import Vue from 'vue';
    export default {
        name: "SectionList",
        components: {
            SectionFormCreate,
            SectionFormEdit
        },
        data() {
            return {
                sections: [],
                paginate: null,
                sectionEditEntity: null,
                sectionEditKey: null,
                users: []
            };
        },
        mounted() {
            window.axios.get('/sections').then(({data}) => {
                this.sections = data.list;
                this.paginate = data.paginate;
            });
            window.axios.get('/users/all').then(({data}) => {
                this.users = data;
            });
        },
        methods: {
            onPage(page) {
                window.axios.get(`/sections?page=${page}`).then(({data}) => {
                    this.sections = data.list;
                    this.paginate = data.paginate;
                });
            },
            deleteSection(id) {
                window.axios.delete(`/sections/${id}`).then(() => {
                    this.sections = this.sections.filter(item => item.id !== id);
                });
            },
            sectionToEdit(section, key) {
                this.sectionEditEntity = section;
                this.sectionEditKey = key;
            },
            sectionEdit(section) {
                Vue.set(this.sections, this.sectionEditKey, section);
                this.sectionEditEntity = null;
                this.sectionEditKey = null;
            }
        }
    }
</script>

<style scoped>
    img[alt='logo'] {
        max-width: 80px;
        max-height: 80px;
    }
</style>
