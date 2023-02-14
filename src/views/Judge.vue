<template>
    <!-- v-if to force re-render -->
    <judge-score-sheet
        v-if="portionStore.activePortion === 'maj'"
        portion="maj"
    />
    <judge-score-sheet
        v-else-if="portionStore.activePortion === 'dlc'"
        portion="dlc"
    />
</template>


<script lang="ts" setup>
    import { usePortionStore } from '../store/store-portion';


    // components
    import JudgeScoreSheet from '../components/score/JudgeScoreSheet.vue';


    // use hooks
    const portionStore = usePortionStore();
</script>


<style scoped>

</style>