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
    import { onMounted, nextTick, onBeforeUnmount } from 'vue';
    import { useRouter, useRoute } from 'vue-router';
    import { useStore } from './store/store';
    import { useAuthStore } from './store/store-auth';
    import { usePortionStore } from './store/store-portion';


    // components
    import TopBar  from './components/nav/TopBar.vue';
    import SideBar from './components/nav/SideBar.vue';


    // use hooks
    const router = useRouter();
    const route  = useRoute();
    const store  = useStore();
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

    const handleWindowResize = () => {
        store.setWindowHeight(window.innerHeight);
    };


    // onMounted hook
    onMounted(() => {
        getUser();

        // resize event
        nextTick(() => {
            window.addEventListener('resize', handleWindowResize);
            handleWindowResize();
        });
    });


    // onBeforeUnmount hook
    onBeforeUnmount(() => {
        window.removeEventListener('resize', handleWindowResize);
    });
</script>


<style scoped>
    .active {
        font-weight: bold;
    }
</style>