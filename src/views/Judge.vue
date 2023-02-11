<template>
    <div>
        <!--
            Use v-if to force component re-render
            and fire JudgeScoreSheet's onMounted() hook.
        -->
        <JudgeScoreSheet
            v-if="portionStore.activePortion === 'maj'"
            portion="maj"
        />
        <JudgeScoreSheet
            v-else-if="portionStore.activePortion === 'dlc'"
            portion="dlc"
        />
    </div>
</template>


<script lang="ts" setup>
    import { useRouter } from 'vue-router';
    import { useAuthStore } from '../store/store-auth';
    import { usePortionStore } from '../store/store-portion';


    // components
    import JudgeScoreSheet from '../components/score/JudgeScoreSheet.vue'


    // use hooks
    const router = useRouter();
    const authStore = useAuthStore();
    const portionStore = usePortionStore();


    // methods
    const handleSignOut = async () => {
        await authStore.signOut();
        await router.replace({ name: 'sign-in' });
    }
</script>


<style scoped>

</style>