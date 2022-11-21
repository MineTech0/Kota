<script setup lang="ts">
import EquipmentList from "./EquipmentList.vue";
import NewLoanForm from "./NewLoanForm.vue";
import { useLoanStore } from "./LoanStore"

const props = defineProps<{
    equipment: any[];
    userName: string;
}>();

const loanStore = useLoanStore()
loanStore.equipment = props.equipment
loanStore.loan.loaner = props.userName

</script>
<template>
    <div class="row">
        <div class="col-md-6">
            <EquipmentList
                :equipment="loanStore.equipment ?? []"
                @add-equipment="(id) => loanStore.addItemToLoan(id)"
            ></EquipmentList>
        </div>
        <div class="col-md-6">
            <NewLoanForm />
        </div>
    </div>
</template>
