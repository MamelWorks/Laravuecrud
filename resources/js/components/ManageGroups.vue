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
                    <div>Selected group:</div>
                    <div>Id: {{ selected.id }}</div>
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
                                ></b-form-input>
                            </b-form-group>
                            <b-button type="submit" variant="primary">Edit</b-button>
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
export default {
    data() {
        return {
            groups: [],
            fields: ['name'],
            showSelectableField: false,
            selected: [],
            form: [],
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
            this.axios
                .patch(`/api/groups/${this.form.id}`, this.form)
                .then(() => {
                    this.updateGroupList();
            })

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
                .delete(`/api/groups/${this.form.id}`).then(() => {
                this.onGroupRowUnselected();
                this.updateGroupList();
            })
        },
        updateGroupUserList() {
            this.axios
                .get(`api/groups/${this.form.id}/users`)
                .then(response => {
                    this.groupUsers = response.data;
            })
        },
    }
}
</script>
