<template>
    <v-navigation-drawer
        v-model="isOpened"
        permanent
    >
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
    </v-navigation-drawer>
</template>


<script lang="ts" setup>
    import { ref } from 'vue';
    import router from '../../router/router';
    import { usePortionStore } from '../../store/store-portion';
    import { isPortionKeyType } from '../../types/Portion.type';

    // use hooks
    const portionStore = usePortionStore();

    // state
    const isOpened = ref(true);

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