<template>
    <v-dialog
        :model-value="opened"
        persistent
        max-width="360"
    >
        <v-card color="primary" :loading="loading">
            <v-card-title class="text-h5 bg-primary text-white">
                Submit <span class="text-capitalize">{{ entity }}</span>
            </v-card-title>
            <v-card-text class="bg-white">
                <p class="mb-3">
                    Are you sure you want to finalize your {{ entity }} for
                    <b><span class="text-primary">{{ portionStore.portions[portionStore.activePortion].title }}</span>?</b>
                </p>
                <p>Once submitted, your {{ entity }} will be set and unable to be changed.</p>
            </v-card-text>
            <v-card-actions class="bg-white">
                <v-spacer></v-spacer>
                <v-btn
                    color="primary"
                    variant="text"
                    @click="emit('close')"
                    :disabled="loading"
                >
                    <v-icon icon="mdi-arrow-left" start/>
                    Back
                </v-btn>
                <v-btn color="primary" variant="text" :disabled="loading">
                    Submit
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>


<script lang="ts" setup>
    import { usePortionStore } from '../../store/store-portion';


    // use hooks
    const portionStore = usePortionStore();


    // props
    const props = defineProps({
        opened: {
            type: Boolean,
            required: true
        },
        loading: {
            type: Boolean,
            required: true
        },
        entity: {
            type: String,
            required: false,
            default: 'ratings'
        }
    });

    // emits
    const emit = defineEmits(['close']);
</script>


<style scoped>

</style>