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
            >
                <span class="text-button">{{ portion.title }}</span>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
</template>


<script lang="ts" setup>
    import { ref } from 'vue';
    import { usePortionStore } from '../../store/store-portion';

    // use hooks
    const portionStore = usePortionStore();

    // state
    const isOpened = ref(true);
</script>


<style scoped>

</style>