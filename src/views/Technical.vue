<template>
    <div>

    </div>
</template>


<script lang="ts" setup>
    import { useRouter } from 'vue-router';
    import { useAuthStore } from '../store/auth';

    const router = useRouter();
    const authStore = useAuthStore();

    const handleSignOut = async () => {
        await authStore.signOut();
        await router.replace({ name: 'sign-in' });
    }
</script>


<style scoped>

</style>