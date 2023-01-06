<template>
    <div>
        <h2 class="text-center">Create User</h2>
        <b-card>
            <div>
                <b-form @submit="createUser">
                    <b-form-group id="input-group-1" label="User Name:" label-for="input-1">
                        <b-form-input
                            id="input-1"
                            v-model="form.name"
                            placeholder="Enter name"
                            required
                            @input="v$.form.name.$touch()"
                        ></b-form-input>
                        <b-form-invalid-feedback force-show="true"
                                                 v-for="(error, index) of v$.form.name.$errors" :key="index">
                            {{ error.$message }}
                        </b-form-invalid-feedback>
                        <b-form-invalid-feedback force-show="true"
                                                 v-for="(error, index) of responseErrors.name" :key="index">
                            {{ error }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                        id="input-group-2"
                        label="Email address:"
                        label-for="input-2"
                    >
                        <b-form-input
                            id="input-2"
                            v-model="form.email"
                            placeholder="Enter email"
                            required
                            type="email"
                            @input="v$.form.email.$touch()"
                        ></b-form-input>
                        <b-form-invalid-feedback force-show="true"
                                                 v-for="(error, index) of v$.form.email.$errors" :key="index">
                            {{ error.$message }}
                        </b-form-invalid-feedback>
                        <b-form-invalid-feedback force-show="true"
                                                 v-for="(error, index) of responseErrors.email" :key="index">
                            {{ error }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                        id="input-group-3"
                        label="Password:"
                        label-for="input-3"
                    >
                        <b-form-input
                            id="input-3"
                            v-model="form.password"
                            placeholder="Enter password"
                            required
                            type="password"
                            @input="v$.form.password.$touch()"
                        ></b-form-input>
                        <b-form-invalid-feedback force-show="true"
                                                 v-for="(error, index) of v$.form.password.$errors" :key="index">
                            {{ error.$message }}
                        </b-form-invalid-feedback>
                        <b-form-invalid-feedback force-show="true"
                                                 v-for="(error, index) of responseErrors.password" :key="index">
                            {{ error }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group
                        id="input-group-4"
                        description=""
                        label="Confirm password:"
                        label-for="input-4"
                    >
                        <b-form-input
                            id="input-4"
                            v-model="form.password_confirmation"
                            placeholder=""
                            type="password"
                            @input="v$.form.password_confirmation.$touch()"
                        ></b-form-input>
                        <b-form-invalid-feedback force-show="true"
                                                 v-for="(error, index) of v$.form.password_confirmation.$errors" :key="index">
                            {{ error.$message }}
                        </b-form-invalid-feedback>
                        <b-form-invalid-feedback force-show="true"
                                                 v-for="(error, index) of responseErrors.password_confirmation" :key="index">
                            {{ error }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-button :disabled="v$.form.$invalid" type="submit" variant="primary">Submit</b-button>
                </b-form>
            </div>
        </b-card>
    </div>
</template>

<script>
import useVuelidate from "@vuelidate/core";
import {email, helpers, maxLength, minLength, required, sameAs} from "@vuelidate/validators";

export default {
    setup () {
        return { v$: useVuelidate() }
    },
    data() {
        return {
            form: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            responseErrors: {}
        }
    },
    methods: {
        createUser() {
            self = this
            this.axios
                .post(`/api/users`, this.form).then(() => {
                this.form = {};
                self.responseErrors = {}
            }).catch(function (error) {
                if (error.response.status === 422)
                    self.responseErrors = error.response.data.errors})
        }
    },
    validations () {
        return {
            form:{
                name: {
                    required,
                    minLengthValue: minLength(5),
                    maxLengthValue: maxLength(20)
                },
                email: {required, email},
                password: {required,minLengthValue: minLength(8)},
                password_confirmation: {
                    required,
                    sameAsPassword: helpers.withMessage(`Fields password and confirm password does not match`,
                        sameAs(this.form.password)
                    )
                }
            }
        }
    }

}
</script>
