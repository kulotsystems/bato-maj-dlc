<template>

</template>


<script lang="ts" setup>
    import { reactive, onMounted } from 'vue';
    import { useStore } from '../../store/store';
    import { usePortionStore } from '../../store/store-portion';
    import { PortionKeyType } from '../../types/Portion.type';


    // props
    interface AdminScoreViewProps {
        portion: PortionKeyType
    }
    const props = defineProps<AdminScoreViewProps>();


    // use hooks
    const store = useStore();
    const portionStore = usePortionStore();


    // state


    // onMounted hook
    onMounted(() => {

    });
</script>


<style scoped>

</style>