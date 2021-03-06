<template>
    <div class="modal fade" id="modalSectionFormCreate" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Add section
                    </h5>
                </div>
                <div class="modal-body">
                    <template v-for="collectionErrors in this.errors">
                        <div v-for="error in collectionErrors" class="alert alert-danger">
                            {{ error }}
                        </div>
                    </template>
                    <div v-if="success" class="alert alert-success">
                        Section was created
                    </div>
                    <form>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input :class="['form-control', {'is-invalid': $v.section.name.$error || errors.name}]"
                                   v-on:input="(val) => fieldChange(val, 'name')"
                                   type="text"
                                   v-model.trim="$v.section.name.$model" id="name">
                            <div class="invalid-feedback" v-if="!$v.section.name.required">Name is required</div>
                            <div class="invalid-feedback" v-if="!$v.section.name.minLength">
                                Name must be at least {{ $v.section.name.$params.minLength.min }} letters
                            </div>
                            <div class="invalid-feedback" v-if="!$v.section.name.maxLength">
                                Name must be at most {{ $v.section.name.$params.minLength.min }} letters
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea :class="['form-control', {'is-invalid': $v.section.description.$error}]"
                                      v-on:input="(val) => fieldChange(val, 'email')"
                                      type="text"
                                      v-model.trim="$v.section.description.$model" id="description"></textarea>
                            <div class="invalid-feedback" v-if="!$v.section.description.required">Description is
                                required
                            </div>
                        </div>
                        <div class="custom-file">
                            <input class="custom-file-input"
                                   v-on:input="(val) => fieldChange(val, 'description')"
                                   id="image"
                                   ref="image"
                                   v-on:change="getImage()"
                                   type="file">
                            <label class="custom-file-label" for="image">Choose file...</label>
                        </div>
                        <h5 class="mt-3">Users:</h5>
                        <div class="custom-control custom-checkbox" v-for="(user, i) in users" :key="i">
                            <input type="checkbox" :value="user.id" v-model="$v.section.users.$model"
                                   class="custom-control-input"
                                   :id="`userc${user.id}`">
                            <label class="custom-control-label" :for="`userc${user.id}`">
                                {{ user.name }}({{ user.email}})
                            </label>
                        </div>
                        <button :disabled="process || $v.$invalid" @click="send" type="button" class="btn btn-primary">
                            Send
                        </button>
                        <button data-dismiss="modal" class="btn btn-secondary">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {maxLength, minLength, required, numeric} from "vuelidate/lib/validators";
    import FormData from "form-data";

    const sectionInit = {
        id: null,
        name: null,
        description: null,
        logo: null,
        users: []
    }
    export default {
        name: "SectionFormCreate",
        props: {
            users: {
                type: Array,
                default: function () {
                    return [];
                }
            }
        },
        data() {
            return {
                section: {
                    ...sectionInit
                },
                success: null,
                process: false,
                errors: {}
            };
        },
        mounted() {
            $('#modalSectionForm').on('hidden.bs.modal', () => {
                this.modalClose();
            });
            $('#modalSectionForm').on('shown.bs.modal', () => {
                this.modalOpen();
            });
        },
        methods: {
            modalClose() {
                this.$v.$reset();
                this.section = {};
                this.success = null;
                this.errors = {};
                this.process = null;
            },
            modalOpen() {
                this.user = {...sectionInit};
            },
            fieldChange(val, name) {
                if (this.errors[name]) {
                    delete this.errors[name];
                }
                this.success = null;
            },
            getImage() {
                this.section.logo = this.$refs.image.files[0];
            },
            send() {
                this.process = true;
                const formData = new FormData();

                for (let key in this.section) {
                    if (this.section[key] === null) {
                        continue;
                    }
                    formData.append(key, this.section[key]);
                }

                window.axios.post('/sections', formData, {
                    headers: {
                        'accept': 'application/json',
                        'Content-Type': `multipart/form-data; boundary=${formData._boundary}`
                    }
                }).then(() => {
                    this.success = true;
                    this.$v.$reset();
                    this.section = {
                        ...this.sectionInit
                    }
                }).catch(({response}) => {
                    this.process = false;
                    if (response.status === 422) {
                        this.errors = response.data;
                    }
                })
            }
        },
        validations: {
            section: {
                name: {
                    required,
                    minLength: minLength(4),
                    maxLength: maxLength(100)
                },
                description: {
                    required,
                    minLength: minLength(50),
                    maxLength: maxLength(500)
                },
                users: {
                    $each: {
                        numeric
                    }
                }
            }
        }
    }
</script>

<style scoped>

</style>
