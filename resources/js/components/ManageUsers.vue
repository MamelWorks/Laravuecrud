<template>
    <div>
        <h2 class="text-center">List of users</h2>

        <b-table :fields="fields"
                 :items="users"
                 :select-head=showSelectableField
                 hover
                 selectable
                 @rowSelected=onUserRowSelected
                 @rowUnselected=onUserRowUnselected

        >
        </b-table>
        <div>
            <b-tabs v-if="!isHidden"
                    content-class="mt-3">
                <b-tab active title="Inspect">
                    <b-card style="margin-bottom: 10px">
                        <h3>Selected user:</h3>
                        <div v-for="(value, key, index) in selected" :key="`${ key }-${ index }`">
                            <span style="text-transform: capitalize">{{ key }}</span>: {{ value }}
                        </div>
                        <div> Groups:</div>
                        <li v-for="(item) in userGroups">
                            {{ item.name }}
                        </li>
                    </b-card>
                </b-tab>
                <b-tab title="Edit">
                    <b-card>
                        <div>
                            <b-form @submit="updateUser">
                                <b-form-group id="input-group-2" label="User Name:" label-for="input-2">
                                    <b-form-input
                                        id="input-2"
                                        v-model="form.name"
                                        placeholder="Enter name"
                                        required
                                    ></b-form-input>
                                </b-form-group>
                                <b-form-group
                                    id="input-group-1"
                                    label="Email address:"
                                    label-for="input-1"
                                >
                                    <b-form-input
                                        id="input-1"
                                        v-model="form.email"
                                        placeholder="Enter email"
                                        required
                                        type="email"
                                    ></b-form-input>
                                </b-form-group>
                                <b-form-group
                                    id="input-group-3"
                                    description="Leave blank to leave unchanged"
                                    label="Password:"
                                    label-for="input-3"
                                >
                                    <b-form-input
                                        id="input-3"
                                        v-model="form.password"
                                        placeholder=""
                                        type="password"
                                    ></b-form-input>
                                </b-form-group>
                                <b-button type="submit" variant="primary">Save changes</b-button>
                            </b-form>
                        </div>
                    </b-card>
                </b-tab>
                <b-tab title="Edit Groups">
                    <b-card>
                        <b-container>
                            <b-row>
                                <b-col>
                                    <h3>Applied Groups</h3>
                                </b-col>
                                <b-col>
                                    <h3>Available Groups</h3>
                                </b-col>
                            </b-row>
                        </b-container>
                        <b-container>
                            <b-row>
                                <b-col>
                                    <b-table :fields="fields"
                                             :items="userGroups"
                                             :select-head=showSelectableField
                                             hover
                                             @rowClicked=onUserGroupRowSelected
                                    >
                                    </b-table>
                                </b-col>
                                <b-col>
                                    <b-table ref="selectableTable"
                                             :fields="fields"
                                             :items="filteredAvailableGroups"
                                             :select-head=showSelectableField
                                             hover
                                             @rowClicked=onAvailableGroupRowSelected
                                    >
                                    </b-table>
                                </b-col>
                            </b-row>
                        </b-container>
                    </b-card>
                </b-tab>
                <b-tab title="Delete">
                    <b-card>
                        <div class="d-grid gap-2">
                            <b-button @click="deleteUser" block variant="danger">Delete</b-button>
                        </div>
                    </b-card>
                </b-tab>
            </b-tabs>
        </div>
    </div>
</template>

<style>
th {
    display: none;
}
</style>

<script>
export default {
    data() {
        return {
            users: [],
            fields: ['name'],
            showSelectableField: false,
            selected: [],
            form: [],
            userGroups: [],
            availableGroups: [],
            isHidden: true
        }
    },
    created() {
        this.updateUserList();
        this.updateGroupList();

    },
    computed: {
        filteredAvailableGroups() {

            return this.availableGroups.filter(x => !this.userGroups.filter(y => y.id === x.id).length);
        }
    },
    methods: {
        onUserRowSelected(item) {
            this.isHidden = false;
            this.selected = item;
            this.form = JSON.parse(JSON.stringify(item));
            this.updateUserGroupList();
        },
        onUserRowUnselected() {
            this.isHidden = true;
        },
        updateUser() {
            this.axios
                .patch(`/api/users/${this.form.id}`, this.form).then(() => {
                this.updateUserList();

            })
        },
        updateUserList() {
            this.axios
                .get('api/users/')
                .then(response => {
                    this.users = response.data;
                })
        },
        updateUserGroupList() {
            this.axios
                .get(`api/users/${this.form.id}/groups`)
                .then(response => {
                    this.userGroups = response.data;
            })
        },
        updateGroupList() {
            this.axios
                .get(`api/groups/`)
                .then(response => {
                    this.availableGroups = response.data;
            })
        },
        onUserGroupRowSelected(item) {
            this.userGroups = this.userGroups.filter(x => x !== item);
            this.axios
                .delete(`/api/users/${this.form.id}/groups/${item.id}`).then(() => {
            })
        },
        onAvailableGroupRowSelected(item) {
            this.userGroups.push(item);
            this.axios
                .put(`/api/users/${this.form.id}/groups/${item.id}`).then(() => {
            })
        },
        deleteUser() {
            this.axios
                .delete(`/api/users/${this.form.id}`).then(() => {
                this.onUserRowUnselected();
                this.updateUserList();
            })
        }
    }
}
</script>
