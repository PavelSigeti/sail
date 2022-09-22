<template>
    <a @click.prevent="logout" href="#">Logout</a>
</template>

<script>
import {useRouter} from "vue-router";
import axios from "axios";

export default {
    name: "TheNavbar",
    setup() {
        const router = useRouter();

        const logout = async () => {
            await axios.post('/logout');
            localStorage.removeItem('x_xsrf_token');
            router.push('/login');
        };

        return {
            logout
        }
    }
}
</script>
