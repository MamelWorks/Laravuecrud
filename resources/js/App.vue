<template>
    <div class="container">
        <b-nav pills>
            <b-nav-item to="/">Home</b-nav-item>
            <b-nav-item-dropdown
                id="my-nav-dropdown"
                left
                text="Users"
                toggle-class="nav-link-custom"
            >
                <b-dropdown-item to="/users/create">Create new user</b-dropdown-item>
                <b-dropdown-item to="/users">Manage existing users</b-dropdown-item>
            </b-nav-item-dropdown>
            <b-nav-item-dropdown
                id="my-nav-dropdown"
                left
                text="Groups"
                toggle-class="nav-link-custom"
            >
                <b-dropdown-item to="/groups/create">Create new group</b-dropdown-item>
                <b-dropdown-item to="/groups">Manage existing groups</b-dropdown-item>
            </b-nav-item-dropdown>
        </b-nav>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    created() {
        this.axios.interceptors.response.use(
            response => {
                if ((response.data) && (!Array.isArray(response.data))) {
                    console.log(response)
                    this.$toast.success(response.data);
                }
                return response;
            },
            error => {
                console.log(error.response);
                this.$toast.error(error.response.data.message);
                throw error;
            });
    }
}
</script>
