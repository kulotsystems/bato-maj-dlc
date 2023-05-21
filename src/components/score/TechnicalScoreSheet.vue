<template>
    <!-- deductions table -->
    <v-table
        v-if="deductionSheet.ready"
        density="comfortable"
        fixed-header
        hover
        :height="deductionSheetHeight"
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
                    class="py-2"
                    :class="{ 'bg-grey-lighten-4': !deductionSheetDisabled }"
                >
                    <div class="h-100 d-flex justify-center align-center">
                        <div class="text-h6 text-primary">DEDUCTION</div>
                    </div>
                </th>
            </tr>
        </thead>

        <!-- table body -->
        <tbody>
            <tr
                v-for="(contingent, contingentIndex) in deductionSheet.contingents"
                :key="contingent.id"
                :class="{ 'bg-grey-lighten-4': coordinates.y == contingentIndex && !deductionSheetDisabled }"
            >
                <td class="text-h5 text-center text-primary font-weight-bold">{{ contingent.number}}</td>
                <td class="text-subtitle-2">{{ contingent.school }}</td>
                <td
                    :class="{ 'bg-grey-lighten-4': !deductionSheetDisabled }"
                >
                    <v-text-field
                        type="number"
                        class="ma-0"
                        hide-details
                        variant="outlined"
                        single-line
                        :min="store.deduction.min"
                        :max="store.deduction.max"
                        v-model.number="deductionSheet.deductions[`d_${contingent.id}`].value"
                        :error="(
                              deductionSheet.deductions[`d_${contingent.id}`].value.toString().trim() === ''
                           || deductionSheet.deductions[`d_${contingent.id}`].value < store.deduction.min
                           || deductionSheet.deductions[`d_${contingent.id}`].value > store.deduction.max
                       )"
                        :class="{
                            'text-error font-weight-bold': (
                                   deductionSheet.deductions[`d_${contingent.id}`].value < store.deduction.min
                                || deductionSheet.deductions[`d_${contingent.id}`].value > store.deduction.max
                            ),
                            'text-grey': deductionSheet.deductions[`d_${contingent.id}`].value == 0
                        }"
                        :disabled="contingent.is_active == 0 || deductionSheet.deductions[`d_${contingent.id}`].is_locked == 1"
                        :loading="deductionSheet.deductions[`d_${contingent.id}`].loading"
                        :id="`input_${contingentIndex}`"
                        @change="handleDeductionChange(contingent.id)"
                        @keydown.down.prevent="moveDown(contingentIndex)"
                        @keydown.enter="moveDown(contingentIndex)"
                        @keydown.up.prevent="moveUp(contingentIndex)"
                        @focus.passive="updateCoordinates(contingentIndex)"
                    />
                </td>
            </tr>
        </tbody>

        <!-- table footer -->
        <tfoot>
            <tr>
                <th colspan="8">
                    <div class="d-flex justify-end py-5">
                        <v-btn
                            @click="openSubmitDeductionsDialog"
                            color="primary"
                            size="x-large"
                            variant="tonal"
                            block
                            :disabled="deductionsLoading || deductionSheetDisabled"
                        >
                            Submit Deductions
                        </v-btn>
                    </div>
                </th>
            </tr>
        </tfoot>
    </v-table>

    <!-- loader -->
    <div v-else class="d-flex justify-center align-center" :style="{ height: `${deductionSheetHeight}px` }">
        <v-progress-circular
            :size="80"
            color="primary"
            indeterminate
            class="mb-16"
        />
    </div>

    <!-- dialogs -->
    <dialog-submit-ratings
        entity="deductions"
        :opened="submitOpen"
        :loading="submitLoading"
        @close="closeSubmitDeductionsDialog"
        @submit="submitDeductions"
    />
</template>


<script lang="ts" setup>
    import { ref, computed, onMounted, reactive } from 'vue';
    import { useStore } from '../../store/store';
    import { useAuthStore } from '../../store/store-auth';
    import { usePortionStore } from '../../store/store-portion';
    import { PortionKeyType } from '../../types/Portion.type';
    import { DeductionSheetType } from '../../types/ScoreSheet.type';
    import { ContingentIDType } from '../../types/Contingent.type';
    import {
        DeductionPayloadType,
        DeductionFinalsPayloadType,
        DeductionFinalsRowPayloadType
    } from '../../types/Deduction.type';


    // components
    import DialogSubmitRatings from '../../components/dialog/DialogSubmitRatings.vue';


    // props
    interface DeductionSheetProps {
        portion: PortionKeyType
    }
    const props = defineProps<DeductionSheetProps>();


    // use hooks
    const store = useStore();
    const authStore = useAuthStore();
    const portionStore = usePortionStore();


    // state
    const deductionSheet = reactive<DeductionSheetType>({
        contingents: [],
        deductions: {},
        ready: false,
    });
    const coordinates = reactive({
        y: -1
    });
    const submitOpen    = ref(false);
    const submitLoading = ref(false);
    const inspectOpen   = ref(false);


    // computed
    const deductionSheetHeight = computed(() => store.window.height - 64);

    const deductionsLoading = computed(() => {
        let loading = false;
        for(const key in deductionSheet.deductions) {
            if(deductionSheet.deductions[key].loading) {
                loading = true;
                break;
            }
        }
        return loading;
    });

    const deductionSheetDisabled = computed(() => {
        let disabled = true;
        for(const key in deductionSheet.deductions) {
            if(!deductionSheet.deductions[key].is_locked) {
                disabled = false;
                break;
            }
        }
        return disabled;
    });


    // methods
    const getDeductionSheet = async () =>{
        await store.requestAsync('GET', null, `getDeductionSheet=${props.portion}`, `technical.php`)
            .then(result => {
                deductionSheet.contingents = result.contingents;
                deductionSheet.deductions  = result.deductions;
                deductionSheet.ready = true;

                // apply loading key to deductionSheet.deductions
                for(const key in deductionSheet.deductions) {
                    deductionSheet.deductions[key].loading = false;
                }
            });
    };


    const handleDeductionChange  = (contingentID: ContingentIDType) => {
        let enteredDeduction = Number(deductionSheet.deductions[`d_${contingentID}`].value);

        // validate entered deduction
        if(enteredDeduction < store.deduction.min) {
            deductionSheet.deductions[`d_${contingentID}`].value = store.deduction.min;
            enteredDeduction = store.deduction.min;
        }
        else if(enteredDeduction > store.deduction.max) {
            deductionSheet.deductions[`d_${contingentID}`].value = store.deduction.max;
            enteredDeduction = store.deduction.max;
        }

        // send
        sendDeduction(contingentID);
    };


    const sendDeduction = async (contingentID: ContingentIDType) => {
        // start loading
        const deductionObj = deductionSheet.deductions[`d_${contingentID}`];
        deductionObj.loading = true;

        // prepare payload
        const deduction: DeductionPayloadType = {
            portion: props.portion,
            contingentID,
            technicalID: deductionObj.technical_id,
            value: deductionObj.value
        };

        // make request
        await store.requestAsync('POST', { deduction }, '', 'technical.php')
            .then(result => {
                if(result.error) {
                    alert(result.error);
                    window.location.reload();
                }

                // stop loading
                if(deductionObj.loading) {
                    setTimeout(() => {
                        deductionObj.loading = false;
                    }, 1000);
                }
            });
    };


    const submitDeductions = async () => {
        // start loading
        submitLoading.value = true;

        // prepare payload
        const finalDeductions: DeductionFinalsPayloadType = {
            portion: props.portion,
            technicalID: deductionSheet.deductions[Object.keys(deductionSheet.deductions)[0]].technical_id,
            rows: []
        };

        for(let i=0; i<deductionSheet.contingents.length; i++) {
            const contingent = deductionSheet.contingents[i];
            const row: DeductionFinalsRowPayloadType = {
                contingentID: contingent.id,
                value: deductionSheet.deductions[`d_${contingent.id}`].value
            }
            finalDeductions.rows.push(row);
        }

        // submit final deductions
        await store.requestAsync('POST', { finalDeductions }, '', 'technical.php')
            .then(result => {
                if(result.error) {
                    alert(result.error);
                    window.location.reload();
                }

                // stop loading
                if(submitLoading.value) {
                    setTimeout(() => {
                        submitLoading.value = false;
                        submitOpen.value = false;

                        // lock all deductions in scoreSheet
                        for(const key in deductionSheet.deductions) {
                            deductionSheet.deductions[key].is_locked = 1;
                        }
                    }, 1100);
                }
            });
    }


    const openSubmitDeductionsDialog = () => {
        submitOpen.value = true;
    }


    const closeSubmitDeductionsDialog = () => {
        submitOpen.value = false;
        submitLoading.value = false;
    }


    const move = (y: number, callback: false | ((y: number) => void), focus: boolean = true) => {
        // move to input
        const nextInput = document.querySelector(`#input_${y}`) as HTMLInputElement;
        if(nextInput) {
            if(nextInput.disabled) {
                if(callback)
                    callback(y);
            }
            else {
                if(focus)
                    nextInput.focus();
                if(Number(nextInput.value) <= 0)
                    nextInput.select();
            }
        }
    }

    const moveDown = (y: number) => {
        // move to input below
        y += 1;
        if(y < deductionSheet.contingents.length)
            move(y, moveDown);
    };

    const moveUp = (y: number) => {
        // move to input above
        y -= 1;
        if(y >= 0)
            move(y, moveUp);
    };

    const updateCoordinates = (y: number) => {
        coordinates.y = y;
        move(y, false, false);
    };


    // onMounted hook
    onMounted(() => {
        getDeductionSheet();
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