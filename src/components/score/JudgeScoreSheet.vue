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
                        :class="{ 'bg-grey-lighten-4': coordinates.x == criteriaIndex }"
                    >
                        <div class="d-flex h-100 flex-column align-content-space-between">
                            <div class="text-subtitle-2 text-primary">{{ criteria.title }}</div>
                            <div class="text-body-1 text-primary font-weight-bold" style="margin-top: auto">{{ criteria.percentage }}</div>
                        </div>
                    </th>
                    <th
                        class="py-2" style="width: 15%"
                        :class="{ 'bg-grey-lighten-4': coordinates.x == scoreSheet.criteria.length }"
                    >
                        <div class="h-100 d-flex justify-center align-center">
                            <div class="text-h6 text-primary">TOTAL</div>
                        </div>
                    </th>
                    <th>
                        <div class="h-100 d-flex justify-center align-center">
                            <div class="text-h6 text-primary">RANK</div>
                        </div>
                    </th>
                </tr>
            </thead>

            <!-- table body -->
            <tbody>
                <tr
                    v-for="(contingent, contingentIndex) in scoreSheet.contingents"
                    :key="contingent.id"
                    :class="{ 'bg-grey-lighten-4': coordinates.y == contingentIndex }"
                >
                    <td class="text-h5 text-center text-primary font-weight-bold">{{ contingent.number}}</td>
                    <td class="text-subtitle-2">{{ contingent.school }}</td>
                    <td
                        v-for="(criteria, criteriaIndex) in scoreSheet.criteria"
                        :key="criteria.id"
                        :class="{ 'bg-grey-lighten-4': coordinates.x == criteriaIndex }"
                    >
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
                                ),
                                'text-grey': scoreSheet.ratings[`${contingent.id}_${criteria.id}`].value == 0
                            }"
                           :disabled="contingent.is_active == 0 || scoreSheet.ratings[`${contingent.id}_${criteria.id}`].is_locked == 1"
                           :id="`input_${contingentIndex}_${criteriaIndex}`"
                           @change="handleRatingChange(contingent.id, criteria)"
                           @keyup.prevent="handleRatingKeyUp(contingent.id)"
                           @keydown.down.prevent="moveDown(criteriaIndex, contingentIndex)"
                           @keydown.enter="moveDown(criteriaIndex, contingentIndex)"
                           @keydown.up.prevent="moveUp(criteriaIndex, contingentIndex)"
                           @keydown.right.prevent="moveRight(criteriaIndex, contingentIndex)"
                           @keydown.left.prevent="moveLeft(criteriaIndex, contingentIndex)"
                           @focus.passive="updateCoordinates(criteriaIndex, contingentIndex)"
                       />
                    </td>
                    <td :class="{ 'bg-grey-lighten-4': coordinates.x == scoreSheet.criteria.length }">
                        <v-text-field
                            type="number"
                            class="ma-0 font-weight-bold"
                            hide-details
                            single-line
                            variant="outlined"
                            :min="store.rating.min"
                            :max="store.rating.max"
                            v-model.number="scoreTotals[`t_${contingent.id}`].value"
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
                            :disabled="scoreTotals[`t_${contingent.id}`].is_locked == 1"
                            :loading="scoreTotals[`t_${contingent.id}`].loading"
                            :id="`input_${contingentIndex}_${scoreSheet.criteria.length}`"
                            @change="handleTotalChange(contingent.id)"
                            @keydown.down.prevent="moveDown(scoreSheet.criteria.length, contingentIndex)"
                            @keydown.enter="moveDown(scoreSheet.criteria.length, contingentIndex)"
                            @keydown.up.prevent="moveUp(scoreSheet.criteria.length, contingentIndex)"
                            @keydown.right.prevent="moveRight(scoreSheet.criteria.length, contingentIndex)"
                            @keydown.left.prevent="moveLeft(scoreSheet.criteria.length, contingentIndex)"
                            @focus.passive="updateCoordinates(scoreSheet.criteria.length, contingentIndex)"
                        />
                    </td>
                    <td class="text-center text-primary">
                        {{ ranks[`t_${contingent.id}`] }}
                    </td>
                </tr>
            </tbody>

            <!-- table footer -->
            <tfoot>
                <tr>
                    <th colspan="8">
                        <div class="d-flex justify-end py-5">
                            <v-btn
                                color="primary"
                                size="x-large"
                                variant="tonal"
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
    import _ from 'lodash';
    import { computed, onMounted, reactive } from 'vue';
    import { useStore } from '../../store/store';
    import { usePortionStore } from '../../store/store-portion';
    import { PortionKeyType } from '../../types/Portion.type';
    import { ScoreSheetType } from '../../types/ScoreSheet.type';
    import { ContingentIDType } from '../../types/Contingent.type';
    import {
        RatingIsLockedType,
        RatingPayloadType,
        RatingTotalsType,
        RatingTotalType,
        RatingValueType
    } from '../../types/Rating.type';
    import { CriteriaType } from '../../types/Criteria.type';


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
    const coordinates = reactive({
        x: -1,
        y: -1
    });


    // computed
    const scoreSheetHeight = computed(() => store.window.height - 64);
    const ranks = computed(() => {
        // get the value of the 'value' property from each object in the 'scoreTotals' object
        const scores = _.map(scoreTotals, (obj: RatingTotalType) => obj.value);

        // sort the 'scores' array in descending order
        const sortedScores = _.sortBy(scores, (score: RatingValueType) => score).reverse();

        // create a map of scores to their ranks
        const scoreRankMap = _.reduce(sortedScores, (result: { [key: number]: number[] }, score: RatingValueType, index: number) => {
            // if the score is not already in the 'result' object, create an empty array
            result[score] = result[score] || [];
            // add the rank (index + 1) to the array of scores
            result[score].push(index + 1);
            return result;
        }, {});

        // compute the average rank of each score
        return _.mapValues(scoreTotals, (obj: RatingTotalType, key: string) => {
            const score = obj.value;
            const ranks = scoreRankMap[score];
            return _.sum(ranks) / ranks.length;
        });
    });


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
                        is_locked: totalLocked as RatingIsLockedType,
                        loading: false
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

        // send
        sendRatings(contingentID);
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

        // send
        sendRatings(contingentID);
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


    const sendRatings = async (contingentID: ContingentIDType) => {
        // start loading
        const scoreTotal = scoreTotals[`t_${contingentID}`];
        scoreTotal.loading = true;

        // prepare payload
        const ratings: RatingPayloadType = {
            portion: props.portion,
            contingentID,
            judgeID: 0,
            values: []
        };

        for(let i=0; i<scoreSheet.criteria.length; i++) {
            const criteria = scoreSheet.criteria[i];
            const rating   = scoreSheet.ratings[`${contingentID}_${criteria.id}`];
            ratings.judgeID = rating.judge_id;
            ratings.values.push({
                criteriaID: criteria.id,
                value: rating.value
            });
        }

        // make request
        await store.requestAsync('POST', { ratings }, '', 'judge.php')
            .then(result => {
                // stop loading
                if(scoreTotal.loading) {
                    setTimeout(() => {
                        scoreTotal.loading = false;
                    }, 1000);
                }
            });
    };


    const move = (x: number, y: number, focus: boolean = true) => {
        // move to input
        const nextInput = document.querySelector(`#input_${y}_${x}`) as HTMLInputElement;
        if(nextInput) {
            if(focus)
                nextInput.focus();
            if(Number(nextInput.value) <= 0)
                nextInput.select();
        }
    }

    const moveDown = (x: number, y: number) => {
        // move to input below
        y += 1;
        if(y < scoreSheet.contingents.length)
            move(x, y);
    };

    const moveUp = (x: number, y: number) => {
        // move to input above
        y -= 1;
        if(y >= 0)
            move(x, y);
    };

    const moveRight = (x: number, y: number) => {
        // move to input to the right
        x += 1;
        if(x <= scoreSheet.criteria.length)
            move(x, y);
    };

    const moveLeft = (x: number, y: number) => {
        // move to input to the left
        x -= 1;
        if(x >= 0)
            move(x, y);
    };

    const updateCoordinates = (x: number, y: number) => {
        coordinates.x = x;
        coordinates.y = y;
        move(x, y, false);
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