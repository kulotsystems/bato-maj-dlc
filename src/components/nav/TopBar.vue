<template>
    <v-app-bar color="primary">
        <!-- title -->
        <v-app-bar-title class="text-uppercase">
            {{ route.meta.title }}
            <template v-if="authStore.user">
                {{ authStore.user?.number }}
            </template>
        </v-app-bar-title>

        <!-- append when there is a user -->
        <template v-if="authStore.user" v-slot:append>
            <span class="text-uppercase">
                {{ authStore.user?.fullName }}
            </span>

            <v-menu content-class="dropdown" offset-y transition="slide-y-transition">
                <template v-slot:activator="{ props }">
                    <v-btn icon variant="text" v-bind="props" size="small">
                        <v-icon icon="mdi-dots-vertical"/>
                    </v-btn>
                </template>
                <v-list>
                    <v-btn
                        @click="handleSignOut"
                        :loading="loading"
                        variant="text"
                        color="error"
                    >
                        Sign out
                    </v-btn>
                </v-list>
            </v-menu>
        </template>
    </v-app-bar>
</template>


<script lang="ts" setup>
    import { ref } from 'vue';
    import { useRouter, useRoute } from 'vue-router';
    import { useStore } from '../../store/store';
    import { useAuthStore } from '../../store/store-auth';

    // use hooks
    const router = useRouter();
    const route  = useRoute();
    const store  = useStore();
    const authStore = useAuthStore();

    // state
    const loading = ref(false);

    // methods
    const handleSignOut = async () => {
        loading.value = true;
        await authStore.signOut();
        await router.replace({ name: 'sign-in' });
        loading.value = false;
    }
</script>


<style scoped>

</style>