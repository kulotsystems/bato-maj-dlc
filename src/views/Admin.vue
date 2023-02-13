<template>
    <!-- v-if to force re-render -->
    <admin-score-view
        v-if="portionStore.activePortion === 'maj'"
        portion="maj"
    />
    <admin-score-view
        v-else-if="portionStore.activePortion === 'dlc'"
        portion="dlc"
    />
</template>


<script lang="ts" setup>
    import { usePortionStore } from '../store/store-portion';


    // components
    import AdminScoreView from '../components/score/AdminScoreView.vue';


    // use hooks
    const portionStore = usePortionStore();
</script>


<style scoped>

</style>