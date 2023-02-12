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
                            <div class="text-h6 text-primary text-uppercase font-weight-bold">
                                {{ portionStore.portions[portion].title }}
                            </div>
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
                           :min="0"
                           :max="criteria.percentage"
                           v-model.number="scoreSheet.ratings[`${contingent.id}_${criteria.id}`].value"
                           :variant="
                                  scoreSheet.ratings[`${contingent.id}_${criteria.id}`].value > criteria.percentage
                               || scoreSheet.ratings[`${contingent.id}_${criteria.id}`].value < 0
                               ? 'outlined' : 'underlined'
                           "
                           :error="(
                                  scoreSheet.ratings[`${contingent.id}_${criteria.id}`].value.toString().trim() === ''
                               || scoreSheet.ratings[`${contingent.id}_${criteria.id}`].value < 0
                               || scoreSheet.ratings[`${contingent.id}_${criteria.id}`].value > criteria.percentage
                           )"
                           :class="{
                                'text-error font-weight-bold': (
                                       scoreSheet.ratings[`${contingent.id}_${criteria.id}`].value < 0
                                    || scoreSheet.ratings[`${contingent.id}_${criteria.id}`].value > criteria.percentage
                                )
                            }"
                           :disabled="contingent.is_active == 0 || scoreSheet.ratings[`${contingent.id}_${criteria.id}`].is_locked == 1"
                           @keyup="handleRatingKeyUp(contingent.id)"
                           @change="handleRatingChange(contingent.id, criteria)"
                       />
                    </td>
                    <td>
                        <v-text-field
                            type="number"
                            class="ma-0 font-weight-bold"
                            hide-details
                            single-line
                            variant="outlined"
                            :min="store.rating.min"
                            :max="store.rating.max"
                            v-model.number="scoreTotals[`t_${contingent.id}`].value"
                            :error="(
                                  scoreTotals[`t_${contingent.id}`].value.toString().trim() === ''
                               || scoreTotals[`t_${contingent.id}`].value < store.rating.min
                               || scoreTotals[`t_${contingent.id}`].value > store.rating.max
                           )"
                            :class="{
                                'text-error': (
                                       scoreTotals[`t_${contingent.id}`].value < store.rating.min
                                    || scoreTotals[`t_${contingent.id}`].value > store.rating.max
                                ),
                                'text-success': (
                                       scoreTotals[`t_${contingent.id}`].value >= store.rating.min
                                    && scoreTotals[`t_${contingent.id}`].value <= store.rating.max
                                )
                            }"
                            :prepend-inner-icon="
                                    scoreTotals[`t_${contingent.id}`].value >= store.rating.min
                                 && scoreTotals[`t_${contingent.id}`].value <= store.rating.max
                                 ? 'mdi-check-circle' : 'mdi-close-circle'
                            "
                            :disabled="scoreTotals[`t_${contingent.id}`].is_locked == 1"
                            @change="handleTotalChange(contingent.id)"
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
    import { usePortionStore } from '../../store/store-portion';
    import { PortionKeyType } from '../../types/Portion.type';
    import { ScoreSheetType } from '../../types/ScoreSheet.type';
    import { ContingentIDType } from '../../types/Contingent.type';
    import { RatingValueType, RatingIsLockedType, RatingTotalsType } from '../../types/Rating.type';
    import { CriteriaIDType, CriteriaType } from '../../types/Criteria.type';


    // props
    interface ScoreSheetProps {
        portion: PortionKeyType
    }
    const props = defineProps<ScoreSheetProps>();


    // use hooks
    const store = useStore();
    const portionStore = usePortionStore();


    // state
    const scoreSheet = reactive<ScoreSheetType>({
        contingents: [],
        criteria   : [],
        ratings    : {},
        ready      : false,
    });
    const scoreTotals = reactive<RatingTotalsType>({});


    // computed
    const scoreSheetHeight = computed(() => store.window.height - 64);


    // methods
    const getScoreSheet = async () => {
        await store.requestAsync('GET', null, `getScoreSheet=${props.portion}`, `judge.php`)
            .then(result => {
                scoreSheet.contingents = result.contingents;
                scoreSheet.criteria = result.criteria;
                scoreSheet.ratings  = result.ratings;

                // populate scoreTotals
                for(let i=0; i<result.contingents.length; i++) {
                    const contingent = result.contingents[i];
                    let totalValue : RatingValueType  = 0;
                    let totalLocked: RatingIsLockedType = Number(contingent.is_active) == 0 ? 1 : 0;
                    for(let j=0; j<result.criteria.length; j++) {
                        const criteria = result.criteria[j];
                        const rating   = result.ratings[`${contingent.id}_${criteria.id}`];
                        if(totalLocked == 0)
                            totalLocked = rating.is_locked;
                        totalValue += Number(rating.value);
                    }
                    scoreTotals[`t_${contingent.id}`] = {
                        value: totalValue as RatingValueType,
                        is_locked: totalLocked as RatingIsLockedType
                    };
                }

                scoreSheet.ready = true;
            });
    };


    const handleRatingChange = (contingentID: ContingentIDType, criteria: CriteriaType) => {
        // validate entered rating
        let enteredRating = Number(scoreSheet.ratings[`${contingentID}_${criteria.id}`].value);
        if(enteredRating < 0) {
            scoreSheet.ratings[`${contingentID}_${criteria.id}`].value = 0;
            enteredRating = 0;
        }
        else if(enteredRating > criteria.percentage) {
            scoreSheet.ratings[`${contingentID}_${criteria.id}`].value = criteria.percentage;
            enteredRating = criteria.percentage;
        }

        // recompute
        handleRatingKeyUp(contingentID);
    };


    const handleTotalChange = (contingentID: ContingentIDType) => {
        let enteredTotal = Number(scoreTotals[`t_${contingentID}`].value);

        // validate entered total
        if(enteredTotal > 0) {
            if(enteredTotal < store.rating.min) {
                scoreTotals[`t_${contingentID}`].value = store.rating.min;
                enteredTotal = store.rating.min;
            }
            else if(enteredTotal > store.rating.max) {
                scoreTotals[`t_${contingentID}`].value = store.rating.max;
                enteredTotal = store.rating.max;
            }
        }

        // compute individual ratings based on total
        for(let i=0; i<scoreSheet.criteria.length; i++) {
            const criteria = scoreSheet.criteria[i];
            scoreSheet.ratings[`${contingentID}_${criteria.id}`].value = enteredTotal * (criteria.percentage / 100);
        }
    };


    const handleRatingKeyUp = (contingentID: ContingentIDType) => {
        // compute row total
        let total = 0;
        for(let i=0; i<scoreSheet.criteria.length; i++) {
            const criteria = scoreSheet.criteria[i];
            total += Number(scoreSheet.ratings[`${contingentID}_${criteria.id}`].value);
        }
        scoreTotals[`t_${contingentID}`].value = total;
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