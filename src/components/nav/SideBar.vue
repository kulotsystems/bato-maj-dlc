<template>
    <v-navigation-drawer
        v-model="store.sidebar.opened"
        :permanent="$vuetify.display.mdAndUp"
    >
        <v-sheet class="d-flex flex-column justify-center align-center align-center my-5 mx-3">
            <v-avatar size="120" class="mb-3">
                <v-img :src="`/${store.appName}/no-avatar.jpg`"/>
            </v-avatar>
            <div class="text-center">
                <p class="text-h5 text-uppercase">
                    {{ route.meta.title }}
                    <template v-if="authStore.user">
                        {{ authStore.user?.number }}
                    </template>
                </p>
                <p class="text-body-1 text-uppercase">{{ authStore.user?.fullName }}</p>
            </div>
        </v-sheet>

        <v-divider/>

        <v-sheet class="pt-1">
            <v-list nav active-class="bg-primary">
                <v-list-item
                    v-for="(portion, key, index) in portionStore.portions"
                    :key="key"
                    :prepend-icon="portion.icon"
                    :value="key"
                    :active="key === portionStore.activePortion"
                    @click="handlePortionChange(key)"
                >
                    <span class="text-button">{{ portion.title }}</span>
                </v-list-item>
            </v-list>
        </v-sheet>
    </v-navigation-drawer>
</template>


<script lang="ts" setup>
    import router from '../../router/router';
    import { useRoute } from 'vue-router';
    import { useStore } from '../../store/store';
    import { useAuthStore } from '../../store/store-auth';
    import { usePortionStore } from '../../store/store-portion';
    import { isPortionKeyType } from '../../types/Portion.type';

    // use hooks
    const route = useRoute();
    const store = useStore();
    const authStore = useAuthStore();
    const portionStore = usePortionStore();

    // methods
    const handlePortionChange = (key: string) => {
        if(isPortionKeyType(key)) {
            portionStore.setActivePortion(key);

            router.push({
                params: {
                    portion: key
                }
            });
        }
    }
</script>


<style scoped>

</style>