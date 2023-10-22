<script lang="ts" setup>
import useService from "@/composables/useService";
import BudgetService from "@/services/BudgetService";
import { ClubMoney, ParentAgeGroup } from "@/types";
import {
    NButton,
    NForm,
    NFormItemGi,
    NInput,
    NGrid,
    NFormItem,
} from "naive-ui";
import { ref, computed } from "vue";
import Message from "../Message.vue";
const props = defineProps<{
    clubMoneys: ClubMoney[];
}>();

const { fetch, loading, messages } = useService({ reload: false });

const formValue = ref(
    props.clubMoneys.reduce((acc, clubMoney) => {
        acc[clubMoney.age_group] = clubMoney.amount.toString();
        return acc;
    }, {} as Record<ParentAgeGroup, string>)
);

const valueChanged = computed(() => {
    return Object.keys(formValue.value).some((age) => {
        return (
            Number(formValue.value[age]) !=
            props.clubMoneys.find((clubMoney) => clubMoney.age_group === age)
                ?.amount
        );
    });
});

const save = () => {
    const promises: any[] = [];
    Object.keys(formValue.value).forEach((age) => {
        //if changed
        if (
            Number(formValue.value[age]) !=
            props.clubMoneys.find((clubMoney) => clubMoney.age_group === age)
                ?.amount
        ) {
            promises.push(
                BudgetService.saveClubMoney({
                    age_group: age as ParentAgeGroup,
                    amount: formValue.value[age],
                })
            );
        }
    });
    fetch(...promises);
};
</script>
<template>
    <NForm :label-width="40" :model="formValue">
        <NGrid cols="1 400:4" y-gap="8" x-gap="8">
            <NFormItemGi v-for="age in clubMoneys" :label="age.age_group">
                <NInput v-model:value="formValue[age.age_group]"
                    ><template #suffix> € / hlö </template>
                </NInput>
            </NFormItemGi>
        </NGrid>
        <NFormItem>
            <NButton
                :disabled="!valueChanged"
                type="primary"
                :loading="loading"
                @click="save"
                >Tallenna</NButton
            >
        </NFormItem>
        <Message :messages="messages" />
    </NForm>
</template>
