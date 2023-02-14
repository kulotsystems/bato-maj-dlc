<template>
    <!-- results table -->
    <v-table
        v-if="resultSheet.ready"
        density="comfortable"
        fixed-header
        hover
        :height="resultSheetHeight"
    >
        <!-- table header -->
        <thead>
            <tr>
                <!-- th title -->
                <th colspan="2" rowspan="2" class="py-2">
                    <div class="h-100 d-flex justify-center align-center">
                        <div class="text-h6 text-primary text-uppercase font-weight-bold text-center">
                            <p class="font-weight-bold">RESULTS OF</p>
                            {{ portionStore.portions[portion].title }}
                        </div>
                    </div>
                </th>
                <!-- th judges -->
                <th v-for="(judge, judgeIndex) in resultSheet.judges" :key="judge.id">
                    <div class="h-100 d-flex justify-center align-center text-subtitle-1 text-green-darken-4">
                        Judge {{ judge.number }}
                    </div>
                </th>
                <!-- th average -->
                <th>
                    <div class="h-100 d-flex justify-center align-center">
                        <div class="text-subtitle-1 text-green-darken-4 font-weight-bold">
                            AVERAGE
                        </div>
                    </div>
                </th>
                <!-- th technicals -->
                <th v-for="(technical, technicalIndex) in resultSheet.technicals" :key="technical.id">
                    <div class="h-100 d-flex justify-center align-center text-subtitle-1 text-red-darken-2">
                        Tech {{ technical.number }}
                    </div>
                </th>
                <!-- th deductions -->
                <th>
                    <div class="h-100 d-flex justify-center align-center">
                        <div class="text-subtitle-1 text-red-darken-3 font-weight-bold">
                            DEDUCT
                        </div>
                    </div>
                </th>
                <!-- th final -->
                <th>
                    <div class="h-100 d-flex justify-center align-center">
                        <div class="text-subtitle-1 text-black font-weight-bold">
                            FINAL
                        </div>
                    </div>
                </th>
                <!-- th rank -->
                <th>
                    <div class="h-100 d-flex justify-center align-center">
                        <div class="text-subtitle-1 text-primary font-weight-bold">
                            RANK
                        </div>
                    </div>
                </th>
            </tr>
        </thead>

        <tbody>
            <tr
                v-for="(contingent, contingentIndex) in resultSheet.contingents"
                :key="contingent.id"
            >
                <!-- number -->
                <td class="text-h5 text-center text-primary font-weight-bold">{{ contingent.number}}</td>

                <!-- school -->
                <td class="text-subtitle-2">{{ contingent.school }}</td>

                <!-- judge ratings -->
                <td
                    v-for="(judge, judgeIndex) in resultSheet.judges"
                    :key="judge.id"
                    class="text-center text-subtitle-1 text-green-darken-2"
                    :class="{ 'bg-grey-lighten-3': judge.ratings[`c_${contingent.id}`].locked == 0 }"
                >
                    {{ judge.ratings[`c_${contingent.id}`].value.toFixed(2) }}
                </td>

                <!-- judge average -->
                <td class="text-center text-green-darken-4 font-weight-bold">
                    {{ contingent.rating.average.toFixed(2) }}
                </td>

                <!-- technical deductions -->
                <td
                    v-for="(technical, technicalIndex) in resultSheet.technicals"
                    :key="technical.id"
                    class="text-center text-subtitle-1 text-red-darken-1"
                    :class="{ 'bg-grey-lighten-3': technical.deductions[`c_${contingent.id}`].locked == 0 }"
                >
                    {{ technical.deductions[`c_${contingent.id}`].value.toFixed(1) }}
                </td>

                <!-- total deductions -->
                <td class="text-center text-red-darken-3 font-weight-bold">
                    {{ contingent.deduction.total.toFixed(1) }}
                </td>

                <!-- final -->
                <td class="text-center text-black font-weight-bold">
                    {{ contingent.final.rating_average.less_deduction_total.toFixed(2) }}
                </td>

                <!-- rank -->
                <td class="text-center text-primary">
                    {{ ranks[`c_${contingent.id}`] }}
                </td>
            </tr>
        </tbody>
    </v-table>

    <!-- loader -->
    <div v-else class="d-flex justify-center align-center" :style="{ height: `${resultSheetHeight}px` }">
        <v-progress-circular
            :size="80"
            color="primary"
            indeterminate
            class="mb-16"
        />
    </div>
</template>


<script lang="ts" setup>
    import _ from 'lodash';
    import { reactive, onMounted, computed } from 'vue';
    import { useStore } from '../../store/store';
    import { usePortionStore } from '../../store/store-portion';
    import { PortionKeyType } from '../../types/Portion.type';
    import { ResultSheetType } from '../../types/Result.type';
    import { RatingValueType } from '../../types/Rating.type';


    // props
    interface AdminScoreViewProps {
        portion: PortionKeyType
    }
    const props = defineProps<AdminScoreViewProps>();


    // use hooks
    const store = useStore();
    const portionStore = usePortionStore();


    // state
    const resultSheet = reactive<ResultSheetType>({
        contingents: [],
        judges     : [],
        criteria   : [],
        technicals : [],
        ready: false
    });


    // computed
    const resultSheetHeight = computed(() => store.window.height - 64);

    const ranks = computed(() => {
        // prepare scoreTotals
        type ScoreTotalType = {
            [key: string]: {
                value: RatingValueType
            }
        }
        const scoreTotals: ScoreTotalType = {};
        for(let i=0; i<resultSheet.contingents.length; i++) {
            const contingent = resultSheet.contingents[i];
            scoreTotals[`c_${contingent.id}`] = {
                value: contingent.final.rating_average.less_deduction_total
            }
        }

        // get the value of the 'value' property from each object in the 'scoreTotals' object
        const scores = _.map(scoreTotals, (obj: { value: RatingValueType }) => obj.value);

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
        return _.mapValues(scoreTotals, (obj: { value: RatingValueType }, key: string) => {
            const score = obj.value;
            const ranks = scoreRankMap[score];
            return _.sum(ranks) / ranks.length;
        });
    });


    // methods
    const getResults = async () => {
        await store.requestAsync('GET', null, `getResults=${props.portion}`, `admin.php`)
            .then(result => {
                resultSheet.contingents = result.contingents;
                resultSheet.judges      = result.judges;
                resultSheet.criteria    = result.criteria;
                resultSheet.technicals  = result.technicals;
                resultSheet.ready = true;

                setTimeout(() => {
                    getResults();
                }, 1500);
            });
    };


    // onMounted hook
    onMounted(() => {
        getResults();
    });
</script>


<style scoped>

</style>