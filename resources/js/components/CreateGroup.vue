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
                        ></b-form-input>
                    </b-form-group>
                    <b-button type="submit" variant="primary">Submit</b-button>
                </b-form>
            </div>
        </b-card>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {}
        }
    },
    methods: {
        createGroup() {
            this.axios
                .post(`/api/groups`, this.form).then(() => {
                this.form = {};
            })
        },
    }
}
</script>
