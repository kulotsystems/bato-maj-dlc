<template>
    <div>
        <!-- ratings table -->
        <v-table
            v-if="scoreSheet.ready"
            density="comfortable"
            fixed-header
            hover
            :height="scoreSheetHeight"
        >
            <!-- table header -->
            <thead>
                <tr>
                    <th colspan="2" class="py-2">
                        <div class="h-100 d-flex justify-center align-center">
                            <div class="text-h6 text-primary">CONTINGENT</div>
                        </div>
                    </th>
                    <th
                        v-for="(criteria, criteriaIndex) in scoreSheet.criteria"
                        :key="criteria.id"
                        class="py-2 text-center"
                        style="width: 15%"
                    >
                        <div class="d-flex h-100 flex-column align-content-space-between">
                            <div class="text-subtitle-2 text-primary">{{ criteria.title }}</div>
                            <div class="text-body-1 text-primary font-weight-bold" style="margin-top: auto">{{ criteria.percentage }}</div>
                        </div>
                    </th>
                    <th class="py-2" style="width: 15%">
                        <div class="h-100 d-flex justify-center align-center">
                            <div class="text-h6 text-primary">TOTAL</div>
                        </div>
                    </th>
                </tr>
            </thead>

            <!-- table body -->
            <tbody>
                <tr v-for="(contingent, contingentIndex) in scoreSheet.contingents" :key="contingent.id">
                    <td class="text-h5 text-center text-primary font-weight-bold">{{ contingent.number}}</td>
                    <td class="text-subtitle-2">{{ contingent.school }}</td>
                    <td v-for="(criteria, criteriaIndex) in scoreSheet.criteria" :key="criteria.id">
                       <v-text-field
                           type="number"
                           class="ma-0"
                           hide-details
                           single-line
                           variant="underlined"
                           v-model.number="scoreSheet.ratings[`${contingent.id}_${criteria.id}`].value"
                           :disabled="contingent.is_active == 0 || scoreSheet.ratings[`${contingent.id}_${criteria.id}`].is_locked == 1"
                       />
                    </td>
                    <td>
                        <v-text-field
                            type="number"
                            class="ma-0"
                            hide-details
                            single-line
                            variant="outlined"
                        />
                    </td>
                </tr>
            </tbody>

            <!-- table footer -->
            <tfoot>
                <tr><th colspan="7"></th></tr>
                <tr>
                    <th colspan="7">
                        <div class="d-flex justify-end">
                            <v-btn
                                color="primary"
                                size="large"
                                block
                            >
                                Submit Ratings
                            </v-btn>
                        </div>
                    </th>
                </tr>
            </tfoot>
        </v-table>

        <!-- loader -->
        <div v-else class="d-flex justify-center align-center" :style="{ height: `${scoreSheetHeight}px` }">
            <v-progress-circular
                :size="80"
                color="primary"
                indeterminate
                class="mb-16"
            />
        </div>
    </div>
</template>


<script lang="ts" setup>
    import { computed, reactive, onMounted } from 'vue';
    import { useStore } from '../../store/store';
    import { PortionKeyType } from '../../types/Portion.type';
    import { ScoreSheetType } from '../../types/ScoreSheet.type';
    import { RatingType } from '../../types/Rating.type';


    // props
    interface ScoreSheetProps {
        portion: PortionKeyType
    }
    const props = defineProps<ScoreSheetProps>();


    // use hooks
    const store = useStore();


    // state
    const scoreSheet = reactive<ScoreSheetType>({
        contingents: [],
        criteria   : [],
        ratings    : null,
        ready      : false,
    });


    // computed
    const scoreSheetHeight = computed(() => store.window.height - 64);


    // methods
    const getScoreSheet = async () => {
        await store.requestAsync('GET', null, `getScoreSheet=${props.portion}`, `judge.php`)
            .then(result => {
                scoreSheet.contingents = result.contingents;
                scoreSheet.criteria = result.criteria;
                scoreSheet.ratings  = result.ratings;
                scoreSheet.ready = true;
            });
    };

    // onMounted hook
    onMounted(() => {
        getScoreSheet();
    });

</script>


<style>
    tbody td {
        height: 64px !important;
    }

    tbody .v-text-field input {
        text-align: center !important;
    }
</style>