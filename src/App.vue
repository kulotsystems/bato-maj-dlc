<template>
    <div>
        <router-link :class="{ 'active': route.name === 'sign-in'}" :to="{ name: 'sign-in' }">Sign in</router-link> |
        <router-link :class="{ 'active': route.name === 'admin'  }" :to="{ name: 'admin' }">Admin</router-link> |
        <router-link :class="{ 'active': route.name === 'judge'  }" :to="{ name: 'judge' }">Judge</router-link> |
        <router-link :class="{ 'active': route.name === 'technical' }" :to="{ name: 'technical' }">Technical</router-link>
        <router-view/>
    </div>
</template>


<script lang="ts" setup>
    import { onMounted } from 'vue';
    import { useRouter, useRoute } from 'vue-router';
    import { useAuthStore } from './store/authStore';

    const router = useRouter();
    const route  = useRoute();
    const authStore = useAuthStore();

    const getUser = async () => {
        await authStore.getUser();
        if(authStore.user)
            await router.replace({ name: authStore.user.userType });
    }

    onMounted(() => {
        getUser();
    });
</script>


<style scoped>
    .active {
        font-weight: bold;
    }
</style>