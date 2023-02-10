<template>
    <div>
        <h1>Admin</h1>
        <div v-if="authStore.user">
            <p>{{ authStore.user.fullName }}</p>
            <button @click="handleSignOut">Sign out</button>
        </div>
    </div>
</template>


<script lang="ts" setup>
    import { useRouter } from 'vue-router';
    import { useAuthStore } from '../store/authStore';

    const router = useRouter();
    const authStore = useAuthStore();

    const handleSignOut = async () => {
        await authStore.signOut();
        await router.replace({ name: 'sign-in' });
    }
</script>


<style scoped>

</style>