<template>
    <!-- v-if to force re-render -->
    <technical-score-sheet
        v-if="portionStore.activePortion === 'maj'"
        portion="maj"
    />
    <technical-score-sheet
        v-else-if="portionStore.activePortion === 'dlc'"
        portion="dlc"
    />
</template>


<script lang="ts" setup>
    import { usePortionStore } from '../store/store-portion';


    // components
    import TechnicalScoreSheet from '../components/score/TechnicalScoreSheet.vue'


    // use hooks
    const portionStore = usePortionStore();
</script>


<style scoped>

</style>