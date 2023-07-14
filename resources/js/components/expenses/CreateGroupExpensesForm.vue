<script lang="ts" setup>
import {
    NForm,
    NFormItem,
    NInput,
    NSelect,
    NButton,
    NSpace,
    NAlert,
    FormInst,
    FormValidationError,
    NSpin,
    NInputNumber,
    NDatePicker,
    NGrid,
    NGi,
    NCard,
} from "naive-ui";
import { computed, reactive, ref } from "vue";
import { Group } from "../../types";
import { useCreateExpensesStore } from "./CreateExpenseStore";
import { storeToRefs } from "pinia";
import Message from "../Message.vue";
import useService from "@/composables/useService";

const props = defineProps<{
    groups: Group[];
}>();

const formRef = ref<FormInst | null>(null);

const today = new Date().getTime();
const firstDayOfTheYear = new Date(new Date().getFullYear(), 0, 1);

const disableFuture = (date) => {
    return  date > Date.now() || firstDayOfTheYear > date
};

const expenseStore = useCreateExpensesStore()
const { groupExpenses } = storeToRefs(expenseStore)

const formData = reactive({
    expenses: groupExpenses
});

const groupOptions = computed(() =>
    props.groups.map((g) => ({
        label: g.name,
        value: g.id,
    }))
);

const {fetch, messages, loading} = useService()

const handleSubmit = (e: MouseEvent) => {
    e.preventDefault();
    formRef.value?.validate(
        (errors: Array<FormValidationError> | undefined) => {
            if (!errors) {
                fetch(expenseStore.storeGroupExpenses()).then(() => {
                    expenseStore.resetGroupExpenses()
                })
            }
        }
    );
};

</script>

<template>
        <n-space vertical>
            <n-form ref="formRef" :model="formData">
                <n-card
                    v-for="(item, index) in formData.expenses"
                    :key="index"
                    :title="`Kulu ${index + 1}`"
                    :style="{
                        marginBottom: '12px',
                    }"
                >
                    <n-grid x-gap="6" y-gap="12" cols="1 600:5">
                        <n-gi>
                            <n-form-item
                                :show-label="false"
                                :rule="{
                                    required: true,
                                    trigger: ['input', 'blur'],
                                    message: 'Valitse ryhmä',
                                    type: 'number',
                                }"
                                :path="`expenses[${index}].groupId`"
                            >
                                <n-select
                                    v-model:value="item.groupId"
                                    placeholder="Ryhmä"
                                    :options="groupOptions"
                                />
                            </n-form-item>
                        </n-gi>
                        <n-gi>
                            <n-form-item
                                :show-label="false"
                                :rule="[
                                    {
                                        min: 0.1,
                                        trigger: ['input', 'blur'],
                                        message: 'Määrä on liian pieni',
                                        type: 'number',
                                    },
                                ]"
                                :path="`expenses[${index}].amount`"
                            >
                                <n-input-number
                                    v-model:value="item.amount"
                                    clearable
                                    :show-button="false"
                                    :precision="2"
                                    :min="0"
                                    :style="{
                                        width: '100%',
                                    }"
                                    ><template #suffix
                                        >€</template
                                    ></n-input-number
                                >
                            </n-form-item>
                        </n-gi>
                        <n-gi>
                            <n-form-item
                                :show-label="false"
                                :rule="[
                                    {
                                        required: true,
                                        trigger: ['input', 'blur'],
                                        message: 'Päivä vaaditaan',
                                        type: 'number',
                                    },
                                    {
                                        trigger: ['input', 'blur'],
                                        message: 'Ei voi olla tulevaisuudessa',
                                        max: today,
                                        type: 'number',
                                    },
                                ]"
                                :path="`expenses[${index}].expense_date`"
                            >
                                <n-date-picker
                                    v-model:value="item.expense_date"
                                    type="date"
                                    :is-date-disabled="disableFuture"
                                    :style="{
                                        width: '100%',
                                    }"
                                />
                            </n-form-item>
                        </n-gi>
                        <n-gi>
                            <n-form-item
                                :show-label="false"
                                :rule="{
                                    required: true,
                                    trigger: ['input', 'blur'],
                                    message: 'Kuvaus vaaditaan',
                                }"
                                :path="`expenses[${index}].description`"
                            >
                                <n-input
                                    v-model:value="item.description"
                                    placeholder="Kuvaus"
                                    type="text"
                                />
                            </n-form-item>
                        </n-gi>
                        <n-gi>
                            <n-button
                                v-if="index !== 0"
                                @click="expenseStore.removeGroupExpense(index)"
                                type="error" 
                                ghost
                            >
                                Poista
                            </n-button>
                        </n-gi>
                    </n-grid>
                </n-card>
                <n-button
                    attr-type="button"
                    @click="expenseStore.addGroupExpense"
                    type="info" ghost
                >
                    Lisää kulu
                </n-button>
                <n-form-item>
                    <n-space>
                            <n-button :loading="loading" type="primary" @click="handleSubmit"
                                >Lähetä kulut</n-button
                            >
                            <n-button :disabled="loading" type="tertiary" @click="expenseStore.resetGroupExpenses"
                                >Nollaa</n-button
                            >
                    </n-space>
                </n-form-item>
            </n-form>
            <Message :messages="messages"/>
        </n-space>
</template>
