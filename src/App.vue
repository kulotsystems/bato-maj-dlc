<template>
    <div>
        <h1>{{ data }}</h1>
    </div>
</template>


<script lang="ts" setup>
    import { onMounted, ref } from "vue";
    import { useMainStore } from './stores/mainStore';

    const mainStore = useMainStore();
    const data = ref('value');

    onMounted(() => {
        const fetchData = async () => {
            // await fetch('app/index.php')
            await fetch(`${mainStore.appURL}/index.php`)
                .then(response => response.json())
                .then(result => {
                    console.log('result: ', result);
                    data.value = result.data;
                })
                .catch(error => {
                    console.log('error: ', error)
                });
        };
        fetchData();
    });

</script>


<style scoped>

</style>