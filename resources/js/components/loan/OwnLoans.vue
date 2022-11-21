<script setup lang="ts">
import { reactive, ref } from "vue";
import useModal from "../../stores/Modal";
import { Loan } from "../../types";
import Modal from "../Modal.vue";
import Panel from "../Panel.vue";
import LoanInfoModal from "./LoanInfoModal.vue";
import LoanStatusBadge from "./LoanStatusBadge.vue";
import LoanService from "../../services/LoanService";

const props = defineProps<{
    ownLoans: Loan[];
}>();

const modal = useModal();

const isLoading = reactive({});

const showLoanModal = (loanId: number) => {
    isLoading[loanId] = true
    LoanService.getLoan(loanId)
        .then((result) => {
            isLoading[loanId] = false
            modal.open(LoanInfoModal, { loan: result });
        })
        .catch((err) => {
            isLoading[loanId] = false
            console.log(err);
        });
};
</script>
<template>
    <Panel id="own-loans" header="Omat lainat">
        <div class="table-responsive">
            <table
                id="OwnLoansTable"
                class="display table table-striped table-bordered table-hover"
                cellspacing="0"
                width="100%"
            >
                <thead>
                    <tr>
                        <th>Nimi</th>
                        <th>Sarjanumero</th>
                        <th>Määrä</th>
                        <th>Paikka</th>
                        <th>Lainapäivä</th>
                        <th>Viimeinen palautuspäivä</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="loan, i in props.ownLoans">
                        <td>
                            {{ loan.equipment.name }}
                            <LoanStatusBadge
                                :state="loan.state"
                                :return-date="loan.return_date"
                            />
                        </td>
                        <td>{{ loan.equipment.serial }}</td>
                        <td>{{ loan.quantity }}</td>
                        <td>{{ loan.equipment.location }}</td>
                        <td>{{ loan.loan_date }}</td>
                        <td>{{ loan.return_date }}</td>
                        <td>
                            <button
                                @click="showLoanModal(loan.id)"
                                class="btn btn-primary btn-sm"
                            >
                                <div
                                    v-if="isLoading[loan.id]"
                                    class="spinner-border spinner-border-sm"
                                    role="status"
                                >
                                    <span class="sr-only">Ladataan...</span>
                                </div>
                                <div v-else>Avaa tiedot</div>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </Panel>
    <Modal />
</template>
