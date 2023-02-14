<template>
    <!-- v-if to force re-render -->
    <admin-results
        v-if="portionStore.activePortion === 'maj'"
        portion="maj"
    />
    <admin-results
        v-else-if="portionStore.activePortion === 'dlc'"
        portion="dlc"
    />
</template>


<script lang="ts" setup>
    import { usePortionStore } from '../store/store-portion';


    // components
    import AdminResults from '../components/score/AdminResults.vue';


    // use hooks
    const portionStore = usePortionStore();
</script>


<style scoped>

</style>