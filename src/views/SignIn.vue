<template>
    <div>
        <h1>Sign in</h1>

        <form @submit="handleSignIn">
            <div>
                <label for="username">Username:</label>
                <input type="text" v-model="username" id="username">
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="text" v-model="password" id="password">
            </div>
            <button type="submit">Sign in</button>
        </form>
    </div>
</template>


<script lang="ts" setup>
    import { ref } from 'vue';
    import { useRouter } from 'vue-router';
    import { useAuthStore } from '../store/auth';

    const router = useRouter();
    const authStore = useAuthStore();

    // state
    const username = ref('');
    const password = ref('');
    const loading  = ref(false);

    // methods
    const handleSignIn = async (e: Event) => {
        e.preventDefault();
        loading.value = true;
        await authStore.signIn(username.value, password.value);
        const user = authStore.user;
        if(user) {
            await router.replace({ name: user.userType });
        }
        loading.value = false;
    };
</script>


<style scoped>

</style>