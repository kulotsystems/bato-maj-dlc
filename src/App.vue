<template>
    <v-app>
        <top-bar/>
        <side-bar v-if="authStore.user"/>
        <v-main>
            <router-view/>
        </v-main>
    </v-app>
</template>


<script lang="ts" setup>
    import { onBeforeMount, onMounted } from 'vue';
    import { useRouter, useRoute } from 'vue-router';
    import { useAuthStore } from './store/store-auth';
    import { usePortionStore } from './store/store-portion';


    // components
    import TopBar  from './components/nav/TopBar.vue';
    import SideBar from './components/nav/SideBar.vue';


    // use hooks
    const router = useRouter();
    const route  = useRoute();
    const authStore = useAuthStore();
    const portionStore = usePortionStore();


    // methods
    const getUser = async () => {
        await authStore.getUser();
        if(authStore.user) {
            await router.replace({
                name: authStore.user.userType,
                params: {
                    portion: portionStore.activePortion
                }
            });
        }
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