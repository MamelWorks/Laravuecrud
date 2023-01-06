<template>
    <div>
        <h2 class="text-center">Group List</h2>

        <b-table :fields="fields"
                 :items="groups"
                 :select-head=showSelectableField
                 hover
                 selectable
                 @rowSelected=onGroupRowSelected
                 @rowUnselected=onGroupRowUnselected
        >
        </b-table>

        <b-tabs v-if="!isHidden"
                content-class="mt-3">
            <b-tab active title="Inspect">
                <b-card>
                    <h3>Selected group:</h3>
                    <div>Uuid: {{ selected.uuid }}</div>
                    <div>Name: {{ selected.name }}</div>
                    <div> Users:</div>
                    <li v-for="(item) in groupUsers">
                        {{ item.name }}
                    </li>
                </b-card>
            </b-tab>
            <b-tab title="Edit">
                <b-card>
                    <div>
                        <b-form @submit="updateGroup">
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
                            <b-button :disabled="v$.form.$invalid" type="submit" variant="primary">Edit</b-button>
                        </b-form>
                    </div>
                </b-card>
            </b-tab>
            <b-tab title="Delete">
                <b-card>
                    <div class="d-grid gap-2">
                        <b-button @click="deleteGroup" block variant="danger">Delete</b-button>
                    </div>
                </b-card>
            </b-tab>
        </b-tabs>
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
            groups: [],
            fields: ['name'],
            showSelectableField: false,
            selected: [],
            form: {
                name: ''
            },
            responseErrors: {},
            isHidden: true,
            groupUsers: []
        }

    },

    created() {
        this.updateGroupList();

    },
    methods: {
        onGroupRowSelected(item) {
            this.selected = item;
            this.isHidden = false;
            this.form = JSON.parse(JSON.stringify(item));
            this.updateGroupUserList();
        },
        onGroupRowUnselected() {
            this.isHidden = true;
        },
        updateGroup() {
            self = this
            this.axios
                .patch(`/api/groups/${this.form.uuid}`, this.form)
                .then(() => {
                    this.updateGroupList();
                    self.responseErrors = {}
                }).catch(function (error) {
                if (error.response.status === 422)
                    self.responseErrors = error.response.data.errors})

        },
        updateGroupList() {
            this.axios
                .get('api/groups/')
                .then(response => {
                    this.groups = response.data;
                });
        },
        deleteGroup() {
            this.axios
                .delete(`/api/groups/${this.form.uuid}`).then(() => {
                this.onGroupRowUnselected();
                this.updateGroupList();
            })
        },
        updateGroupUserList() {
            this.axios
                .get(`api/groups/${this.form.uuid}/users`)
                .then(response => {
                    this.groupUsers = response.data;
            })
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
