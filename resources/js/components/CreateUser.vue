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
                        ></b-form-input>
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
                        ></b-form-input>
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
        createUser() {
            this.axios
                .post(`/api/users`, this.form).then(() => {
                this.form = {};
            })
        }
    }
}
</script>
