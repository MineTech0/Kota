<script setup lang="ts">
import { NAlert } from "naive-ui";
import { onBeforeMount, ref, watch } from "vue";
import { Loan } from "../../types";
import LoanService from "./../../services/LoanService";
import LoanStatusBadge from "./LoanStatusBadge.vue";

const props = defineProps<{
    loan: Loan;
}>();


const message = ref<string | undefined>(undefined)
const error = ref<string | undefined>(undefined)

const returnLoan = (isAccepted: boolean) => {
    LoanService.returnLoan(props.loan.id).then((result) => {
        message.value = isAccepted ? 'Palautettu' : 'Poistettu'
        setTimeout(() => {
                    location.reload();
                }, 3000);
    }).catch((err) => {
        error.value = 'Virhe'
    });
};
</script>
<template>
    <h2 class="modal-title" id="exampleModalLongTitle">
        {{ loan?.equipment.name }} laina
        <LoanStatusBadge
            :state="loan?.state"
            :return-date="loan?.return_date"
        />
    </h2>
    <template v-if="loan?.equipment.picture">
        <div class="form-group row">
            <img
                :src="'storage/' + loan?.equipment.picture"
                class="img-thumbnail rounded mx-auto d-block"
                width="200"
            />
        </div>
    </template>

    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Varuste: </label>
        <div class="col-sm-8">
            <input
                class="form-control"
                :placeholder="loan?.equipment.name"
                disabled
            />
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Sarjanumero: </label>
        <div class="col-sm-8">
            <input
                class="form-control"
                :placeholder="loan?.equipment.serial ?? ''"
                disabled
            />
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Kunto: </label>
        <div class="col-sm-8">
            <input
                class="form-control"
                :placeholder="loan?.equipment.form ?? ''"
                disabled
            />
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Paikka: </label>
        <div class="col-sm-8">
            <input
                class="form-control"
                :placeholder="loan?.equipment.location"
                disabled
            />
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Laina-aika: </label>
        <div class="col-sm-4">
            <input
                class="form-control"
                :placeholder="loan?.loan_date"
                disabled
            />
        </div>
        <label class="col-form-label">-</label>
        <div class="col-sm-4">
            <input
                class="form-control"
                :placeholder="loan?.return_date"
                disabled
            />
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Määrä: </label>
        <div class="col-sm-8">
            <input
                class="form-control"
                type="number"
                :placeholder="loan?.quantity.toString()"
                disabled
            />
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Mihin: </label>
        <div class="col-sm-8">
            <input class="form-control" :placeholder="loan?.reason" disabled />
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Kuvaus: </label>
        <div class="col-sm-8">
            <textarea
                class="form-control"
                :placeholder="loan?.desc"
                disabled
                rows="8"
            ></textarea>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-3"></div>
        <div class="col-sm-8">
            <button
                v-if="loan?.state === 1 || loan?.state === 3"
                type="button"
                class="btn btn-primary btn-block"
                @click="() => returnLoan(false)"
            >
                Poista
            </button>

            <button
                v-else
                type="button"
                class="btn btn-primary btn-block"
                @click="() => returnLoan(true)"
            >
                Palauta
            </button>
        </div>
    </div>
    <n-alert v-show="message" title="Onnistui" type="success">
      {{ message }}
    </n-alert>
    <n-alert v-show="error" type="warning">
      Tapahtui virhe
    </n-alert>
</template>
