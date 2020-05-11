<template>
    <div class="modal fade" id="modalUserFormEdit" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Edit user
                    </h5>
                </div>
                <div class="modal-body">
                    <template v-for="collectionErrors in this.errors">
                        <div v-for="error in collectionErrors" class="alert alert-danger">
                            {{ error }}
                        </div>
                    </template>
                    <div v-if="success" class="alert alert-success">
                        User was edited
                    </div>
                    <form>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input :class="['form-control', {'is-invalid': $v.user.name.$error || errors.name}]"
                                   v-on:input="(val) => fieldChange(val, 'name')"
                                   type="text"
                                   v-model.trim="$v.user.name.$model" id="name">
                            <div class="invalid-feedback" v-if="!$v.user.name.required">Name is required</div>
                            <div class="invalid-feedback" v-if="!$v.user.name.minLength">
                                Name must be at least {{ $v.user.name.$params.minLength.min }} letters
                            </div>
                            <div class="invalid-feedback" v-if="!$v.user.name.maxLength">
                                Name must be at most {{ $v.user.name.$params.minLength.min }} letters
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input :class="['form-control', {'is-invalid': $v.user.email.$error || errors.email}]"
                                   v-on:input="(val) => fieldChange(val, 'email')"
                                   type="text"
                                   v-model.trim="$v.user.email.$model" id="email">
                            <div class="invalid-feedback" v-if="!$v.user.email.required">Name is required</div>
                            <div class="invalid-feedback" v-if="!$v.user.email.email">
                                Field Email is invalid format
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input :class="['form-control', {'is-invalid': $v.user.password.$error || errors.password}]"
                                   v-on:input="(val) => fieldChange(val, 'password')"
                                   id="password"
                                   type="password"
                                   v-model.trim="$v.user.password.$model">
                            <div class="invalid-feedback" v-if="!$v.user.password.required">Password is required</div>
                            <div class="invalid-feedback" v-if="!$v.user.password.minLength">
                                Name must be at least {{ $v.user.password.$params.minLength.min }} letters
                            </div>
                            <div class="invalid-feedback" v-if="!$v.user.password.maxLength">
                                Name must be at most {{ $v.user.password.$params.minLength.min }} letters
                            </div>
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
    import {required, minLength, maxLength, email} from 'vuelidate/lib/validators';

    export default {
        name: "UserFormEdit",
        props: {
            userEdit: {
                type: Object,
                required: false
            }
        },
        data() {
            return {
                user: {},
                success: null,
                process: false,
                errors: {},
                userPrevState: {}
            };
        },
        mounted() {
            $('#modalUserFormEdit').on('hidden.bs.modal', () => {
                this.modalClose();
            });
            $('#modalUserFormEdit').on('shown.bs.modal', () => {
                this.modalOpen();
            });
        },
        methods: {
            modalClose() {
                this.$v.$reset();
                this.user = this.userPrevState;
                this.success = null;
            },
            modalOpen() {
                this.user = {...this.userEdit, password: null};
            },
            fieldChange(val, name) {
                if (this.errors[name]) {
                    delete this.errors[name];
                }
                this.success = null;
            },
            send() {
                this.process = true;
                window.axios.put(`/users/${this.user.id}`, JSON.stringify(this.user)).then(() => {
                    this.success = true;
                    this.$emit('user', {...this.user});
                }).catch(({response}) => {
                    this.process = false;
                    if (response.status === 422) {
                        this.errors = response.data;
                    }
                })
            }
        },
        validations: {
            user: {
                name: {
                    required,
                    minLength: minLength(4),
                    maxLength: maxLength(100)
                },
                email: {
                    required,
                    email
                },
                password: {
                    required,
                    minLength: minLength(5),
                    maxLength: maxLength(10)
                }
            }
        }
    }
</script>

<style scoped>

</style>
