<template>
    <v-dialog
        :model-value="opened"
        persistent
        max-width="360"
    >
        <v-card color="error">
            <v-card-title class="text-h5 bg-error text-white">
                Submit Ratings
            </v-card-title>
            <v-card-text class="bg-white text-error">
                <p class="mb-3">
                    Sorry, your ratings cannot be submitted as they must be between
                    <b>{{ store.rating.min }}</b> and <b>{{ store.rating.max }}</b>.
                </p>
                <p>Please adjust your ratings and try submitting again.</p>
            </v-card-text>
            <v-card-actions class="bg-white">
                <v-spacer></v-spacer>
                <v-btn
                    color="error"
                    variant="text"
                    @click="emit('close')"
                >
                    <v-icon icon="mdi-arrow-left" start/>
                    Back
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>


<script lang="ts" setup>
    import { useStore } from '../../store/store';


    // use hooks
    const store = useStore();


    // props
    const props = defineProps({
        opened: {
            type: Boolean,
            required: true
        }
    });

    // emits
    const emit = defineEmits(['close']);
</script>


<style scoped>

</style>