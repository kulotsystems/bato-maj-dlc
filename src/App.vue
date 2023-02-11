<template>
    <v-app>
        <top-bar/>
        <v-main>
            <router-view/>
        </v-main>
    </v-app>
</template>


<script lang="ts" setup>
    import { onMounted } from 'vue';
    import { useRouter, useRoute } from 'vue-router';
    import { useAuthStore } from './store/auth';

    // components
    import TopBar from './components/nav/TopBar.vue';

    // use hooks
    const router = useRouter();
    const route  = useRoute();
    const authStore = useAuthStore();

    // methods
    const getUser = async () => {
        await authStore.getUser();
        if(authStore.user)
            await router.replace({ name: authStore.user.userType });
    }

    // onMounted hook
    onMounted(() => {
        getUser();
    });
</script>


<style scoped>
    .active {
        font-weight: bold;
    }
</style>