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
                <!-- th technicals -->
                <!--
                <th v-for="(technical, technicalIndex) in resultSheet.technicals" :key="technical.id">
                    <div class="h-100 d-flex justify-center align-center text-subtitle-1 text-red-darken-2">
                        Tech {{ technical.number }}
                    </div>
                </th>
                -->
                <!-- th deductions -->
                <th>
                    <div class="h-100 d-flex justify-center align-center">
                        <div class="text-subtitle-1 text-red-darken-3 font-weight-bold">
                            DEDUCT
                        </div>
                    </div>
                </th>
                <!-- th judges -->
                <template v-for="(judge, judgeIndex) in resultSheet.judges" :key="judge.id">
                    <th>
                        <div
                            class="h-100 d-flex justify-center flex-column align-center text-subtitle-1"
                            :class="{
                                'text-green-darken-3': judge.is_chairman == 0,
                                'text-red-darken-3': judge.is_chairman == 1
                            }"
                        >
                            Judge
                            <div v-if="judge.is_chairman == 1">CHAIRMAN</div>
                            <div v-else>{{ judge.number }}</div>
                        </div>
                    </th>
                    <th>
                        <div class="h-100 d-flex justify-center flex-column align-center text-subtitle-1 text-blue-darken-3 font-weight-bold">
                            Rank
                            <div>{{ judge.number }}</div>
                        </div>
                    </th>
                </template>
                <!-- th average -->
                <!--
                <th>
                    <div class="h-100 d-flex justify-center align-center">
                        <div class="text-subtitle-1 text-green-darken-4 font-weight-bold">
                            AVERAGE
                        </div>
                    </div>
                </th>
                -->
                <!-- th final -->
                <th>
                    <div class="h-100 d-flex justify-center align-center">
                        <div class="text-subtitle-1 text-green-darken-4 font-weight-bold">
                            Average
                        </div>
                    </div>
                </th>
                <!-- th rank total -->
                <th>
                    <div class="h-100 d-flex flex-column justify-center align-center">
                        <div class="text-subtitle-1 text-blue-darken-4 font-weight-bold">
                            Total
                            <div class="text-center">Rank</div>
                        </div>
                    </div>
                </th>

                <!-- th initial rank -->
                <th>
                    <div class="h-100 d-flex flex-column justify-center align-center">
                        <div class="text-h6 text-grey-darken-1 font-weight-bold">
                            INITIAL
                            <div class="text-center">RANK</div>
                        </div>
                    </div>
                </th>

                <!-- th final rank -->
                <th>
                    <div class="h-100 d-flex flex-column justify-center align-center">
                        <div class="text-h6 text-black font-weight-bold">
                            FINAL
                            <div class="text-center">RANK</div>
                        </div>
                    </div>
                </th>
            </tr>
        </thead>

        <!-- table body -->
        <tbody>
            <tr
                v-for="(contingent, contingentIndex) in resultSheet.contingents"
                :key="contingent.id"
            >
                <!-- number -->
                <td class="text-h5 text-center text-primary font-weight-bold">{{ contingent.number}}</td>

                <!-- school -->
                <td class="text-subtitle-2">{{ contingent.school }}</td>

                <!-- technical deductions -->
                <!--
                <td
                    v-for="(technical, technicalIndex) in resultSheet.technicals"
                    :key="technical.id"
                    class="text-center text-subtitle-1 text-red-darken-1"
                    :class="{ 'bg-grey-lighten-3': technical.deductions[`c_${contingent.id}`].locked == 0 }"
                >
                    {{ technical.deductions[`c_${contingent.id}`].value.toFixed(2) }}
                </td>
                -->

                <!-- total deductions -->
                <td class="text-right text-red-darken-3 font-weight-bold">
                    {{ contingent.deduction.total.toFixed(2) }}
                </td>

                <!-- judge ratings -->
                <template v-for="(judge, judgeIndex) in resultSheet.judges" :key="judge.id">
                    <td
                        class="text-right text-subtitle-1"
                        :class="{
                            'bg-grey-lighten-3': judge.ratings[`c_${contingent.id}`].locked == 0,
                            'text-green-darken-2': judge.is_chairman == 0,
                            'text-red-darken-2': judge.is_chairman == 1
                        }"
                    >
                        {{ judge.ratings[`c_${contingent.id}`].value.toFixed(2) }}
                    </td>
                    <td
                        class="text-right text-subtitle-1 text-blue-darken-2 font-weight-bold"
                        :class="{ 'bg-grey-lighten-3': judge.ratings[`c_${contingent.id}`].locked == 0 }"
                    >
                        {{ judge.ratings[`c_${contingent.id}`].rank.fraction.toFixed(2) }}
                    </td>
                </template>

                <!-- judge average -->
                <!--
                <td class="text-right text-green-darken-4 font-weight-bold">
                    {{ contingent.rating.average.toFixed(2) }}
                </td>
                -->

                <!-- average -->
                <td class="text-right text-green-darken-3 font-weight-bold">
                    {{ contingent.final.rating_average.less_deduction_total.toFixed(2) }}
                </td>

                <!-- rank total -->
                <td class="text-center text-blue-darken-3 font-weight-bold">
                    {{ contingent.rank.fraction.total.toFixed(2) }}
                </td>

                <!-- initial rank -->
                <td class="text-center text-h6 text-grey-darken-1 font-weight-bold">
                    {{ initialRanks[`c_${contingent.id}`] }}
                </td>

                <!-- final rank -->
                <td class="text-center text-h6 text-black font-weight-bold">
                    {{ finalRanks[`c_${contingent.id}`] }}
                </td>
            </tr>
        </tbody>

        <!-- table footer -->
        <tfoot>
            <tr>
                <td :colspan="7 + (resultSheet.judges.length * 2)" class="justify-center">
                    <v-row>
                        <template
                            v-for="(technical, technicalIndex) in resultSheet.technicals"
                            :key="technical.id"
                        >
                            <v-col :cols="parseInt(((12 / (resultSheet.technicals.length + resultSheet.judges.length)).toString()))">
                                <v-card class="text-center mb-5" flat>
                                    <v-card-title class="pt-16 font-weight-bold">
                                        {{ technical.fullname }}
                                    </v-card-title>
                                    <v-card-text class="text-center">
                                        Technical Judge {{ technical.number }}
                                    </v-card-text>
                                </v-card>
                            </v-col>
                        </template>

                        <template
                            v-for="(judge, judgeIndex) in resultSheet.judges"
                            :key="judge.id"
                        >
                            <v-col :cols="parseInt(((12 / (resultSheet.technicals.length + resultSheet.judges.length)).toString()))">
                                <v-card class="text-center mb-5" flat>
                                    <v-card-title class="pt-16 font-weight-bold">
                                        {{ judge.fullname }}
                                    </v-card-title>
                                    <v-card-text class="text-center">
                                        Judge {{ judge.number }} <template v-if="judge.is_chairman == 1">(Chairman)</template>
                                    </v-card-text>
                                </v-card>
                            </v-col>
                        </template>
                    </v-row>
                </td>
            </tr>
        </tfoot>

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
    import { ResultScoreTotalType } from '../../types/Result.type';


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

    const initialRanks = computed(() => {
        // prepare payload
        const payload: ResultScoreTotalType = {};
        for(let i=0; i<resultSheet.contingents.length; i++) {
            const contingent = resultSheet.contingents[i];
            payload[`c_${contingent.id}`] = {
                value: contingent.rank.fraction.total
            }
        }

        // compute rank
        return computeRank(payload);
    });

    const finalRanks = computed(() => {
        // prepare payload
        const payload: ResultScoreTotalType = {};
        for(let i=0; i<resultSheet.contingents.length; i++) {
            const contingent = resultSheet.contingents[i];
            payload[`c_${contingent.id}`] = {
                value: contingent.rank.fraction.total - (contingent.rating.average * 0.001)
            }
        }

        // compute rank
        return computeRank(payload);
    });


    // methods
    const computeRank = (payload: ResultScoreTotalType) => {
        // get the value of the 'value' property from each object in the 'payload' object
        const scores = _.map(payload, (obj: { value: RatingValueType }) => obj.value);

        // sort the 'scores' array in descending order
        const sortedScores = _.sortBy(scores, (score: RatingValueType) => score);//.reverse();

        // create a map of scores to their ranks
        const scoreRankMap = _.reduce(sortedScores, (result: { [key: number]: number[] }, score: RatingValueType, index: number) => {
            // if the score is not already in the 'result' object, create an empty array
            result[score] = result[score] || [];
            // add the rank (index + 1) to the array of scores
            result[score].push(index + 1);
            return result;
        }, {});

        // compute the average rank of each score
        return _.mapValues(payload, (obj: { value: RatingValueType }, key: string) => {
            const score = obj.value;
            const ranks = scoreRankMap[score];
            return _.sum(ranks) / ranks.length;
        });
    };


    const getResults = async () => {
        await store.requestAsync('GET', null, `getResults=${props.portion}`, `admin.php`)
            .then(result => {
                const results = result.results;
                const portion = result.portion;

                resultSheet.contingents = results.contingents;
                resultSheet.judges      = results.judges;
                resultSheet.criteria    = results.criteria;
                resultSheet.technicals  = results.technicals;
                resultSheet.ready = true;

                // repeat request
                if(portion == portionStore.activePortion) {
                    setTimeout(() => {
                        getResults();
                    }, 2400);
                }
            });
    };


    // onMounted hook
    onMounted(() => {
        getResults();
    });
</script>


<style scoped>
    th, td {
        border: 1px solid #ddd;
    }
</style>