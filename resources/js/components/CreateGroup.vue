<template>
    <div>
        <h2 class="text-center">Create Group</h2>
        <b-card>
            <div>
                <b-form @submit="createGroup">
                    <b-form-group id="input-group-1" label="Group Name:" label-for="input-1">
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
                    <b-button :disabled="v$.form.$invalid" type="submit" variant="primary">Submit</b-button>
                </b-form>
            </div>
        </b-card>
    </div>
</template>

<script>
import useVuelidate from "@vuelidate/core";
import {maxLength, minLength, required} from "@vuelidate/validators";

export default {
    setup () {
        return { v$: useVuelidate() }
    },
    data() {
        return {
            form: {
                name: ''
            },
            responseErrors: {}
        }
    },
    methods: {
        createGroup() {
            self = this;
            this.axios
                .post(`/api/groups`, this.form).then(() => {
                this.form = {};
                self.responseErrors = {}
            }).catch(function (error) {
                if (error.response.status === 422)
                    self.responseErrors = error.response.data.errors})
        },
    },
    validations () {
        return {
            form:{
                name: {
                    required,
                    minLengthValue: minLength(3),
                    maxLengthValue: maxLength(20)
                }
            }
        }
    }
}
</script>
