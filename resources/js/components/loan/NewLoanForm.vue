<script setup lang="ts">
import { startOfToday } from "date-fns";
import { storeToRefs } from "pinia";
import { z } from "zod";
import Panel from "../Panel.vue";
import { useLoanStore } from "./LoanStore";

const loanStore = useLoanStore();

const { errors, loan } = storeToRefs(loanStore);

let loanSchema = z.object({
    loaner: z.string(),
    items: z
        .object({
            id: z.number(),
            name: z.string(),
            quantity: z
                    .number({
                        required_error: "Määrä vaaditaan",
                        invalid_type_error: "Määrän pitää olla numero",
                    })
                    .int()
                    .min(1, { message: "Vähintään yksi kappale vaaditaan" }
            ),
            loanDate: z.preprocess(
                (arg) => {
                    if (typeof arg == "string" || arg instanceof Date)
                        return new Date(arg);
                },
                z.date().min(startOfToday(), {
                    message: "Lainapäivä ei saa olla menneisyydessä",
                })
            ),
            returnDate: z.preprocess(
                (arg) => {
                    if (typeof arg == "string" || arg instanceof Date)
                        return new Date(arg);
                },
                z.date().min(startOfToday(), {
                    message: "Lainapäivä ei saa olla menneisyydessä",
                })
            ),
        })
        .refine(
            (data) => {
                return !!(data.loanDate < data.returnDate);
            },
            {
                message: "Lainapäivän pitää olla ennen palautuspäivää",
                path: ["loanDate"],
            }
        )
        .refine(
            (data) => {
                if (!loanStore.equipment) return false;
                const item = loanStore.equipment.find(
                    (item) => item.id === data.id
                );
                if (item) return data.quantity <= item.quantity;
            },
            {
                message: "Lainattava määrä ylittyy",
                path: ["quantity"],
            }
        )
        .array(),
    description: z.string(),
    reason: z.enum(["Omaan käyttöön", "Partiotapahtumaan"]),
});

const handleSubmit = () => {
    loanStore.errors = undefined;
    const result = loanSchema.safeParse(loanStore.loan);
    console.log(result);
    if (!result.success) {
        // handle error then return
        loanStore.errors = result.error.format();
    } else {
        loanStore.submitLoan();
    }
};
</script>

<template>
    <Panel id="newLoan" header="Uusi laina">
        <form
            @submit.prevent="handleSubmit"
            class="form-horizontal"
            enctype="multipart/form-data"
        >
            <div class="form-row form-group">
                <div class="col-md-3">
                    <label for="heading">Lainaaja</label
                    ><span style="color: red">*</span>
                    <input
                        type="text"
                        name="loaner"
                        class="form-control form-control-lg"
                        :value="loan.loaner"
                        required
                        readonly
                    />
                </div>
            </div>
            <div class="form-row form-group">
                <div class="col">
                    <label for="loanList">Lainat</label>
                    <div class="table-responsive">
                        <table
                            id="loanList"
                            class="table table-striped table-bordered table-hover"
                        >
                            <thead>
                                <tr>
                                    <th>Nimi</th>
                                    <th>Määrä</th>
                                    <th>Lainapäivä</th>
                                    <th>Palautuspäivä</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, i) in loan.items">
                                    <td>
                                        <p>{{ item.name }}</p>
                                        <small class="text-danger">{{
                                            errors?.items[i]?.id?._errors[0]
                                        }}</small>
                                    </td>
                                    <td>
                                        <input
                                            class="form-control quantityInput"
                                            :class="{
                                                'is-invalid':
                                                    errors?.items[i]?.quantity,
                                            }"
                                            type="number"
                                            min="1"
                                            :value="item.quantity"
                                            @input="
                                                item.quantity =
                                                    $event.target.value
                                            "
                                        />
                                        <small class="text-danger">{{
                                            errors?.items[i]?.quantity
                                                ?._errors[0]
                                        }}</small>
                                    </td>
                                    <td>
                                        <input
                                            class="form-control"
                                            type="date"
                                            :class="{
                                                'is-invalid':
                                                    errors?.items[i]?.loanDate,
                                            }"
                                            :value="item.loanDate"
                                            @input="
                                                item.loanDate =
                                                    $event.target.value
                                            "
                                        />
                                        <small class="text-danger">{{
                                            errors?.items[i]?.loanDate
                                                ?._errors[0]
                                        }}</small>
                                    </td>
                                    <td>
                                        <input
                                            class="form-control"
                                            type="date"
                                            :class="{
                                                'is-invalid':
                                                    errors?.items[i]
                                                        ?.returnDate,
                                            }"
                                            :value="item.returnDate"
                                            @input="
                                                item.returnDate =
                                                    $event.target.value
                                            "
                                        />
                                        <small class="text-danger">{{
                                            errors?.items[i]?.returnDate
                                                ?._errors[0]
                                        }}</small>
                                    </td>
                                    <td>
                                        <a
                                            :style="{
                                                cursor: 'pointer',
                                                color: '#37a6c4',
                                            }"
                                            @click="
                                                loanStore.removeItemFromLoan(
                                                    item.id
                                                )
                                            "
                                            >Poista</a
                                        >
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="form-row form-group">
                <div class="col">
                    <label for="description">Kuvaus</label
                    ><span style="color: red">*</span>
                    <textarea
                        class="form-control form-control-lg"
                        name="description"
                        id="description"
                        rows="5"
                        placeholder="Miksi lainaat ja mihin tarkoitukseen?"
                        :value="loan.description"
                        @input="loan.description = $event.target.value"
                        required
                    ></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="">Mihin</label><span style="color: red">*</span>
                <select
                    class="form-control"
                    name="reason"
                    :value="loan.reason"
                    @change="loan.reason = $event.target.value"
                >
                    <option>Partiotapahtumaan</option>
                    <option>Omaan käyttöön</option>
                </select>
            </div>

            <div class="form-group">
                <button
                    type="submit"
                    class="btn btn-primary btn-lg"
                    :disabled="loan.items.length === 0 || loanStore.isLoading"
                >
                    <div
                        v-if="loanStore.isLoading"
                        class="spinner-border spinner-border-sm"
                        role="status"
                    >
                        <span class="sr-only">Lähetetään...</span>
                    </div>
                    <template v-else="ok">
                        {{
                            loan.reason === "Omaan käyttöön"
                                ? "Pyydä lupaa"
                                : "Lainaa"
                        }}
                    </template>
                </button>
            </div>
        </form>
        <div id="info">
            <div
                v-for="message in loanStore.messages"
                class="alert alert-success"
                role="alert"
            >
                {{ message }}
            </div>
        </div>
    </Panel>
</template>
