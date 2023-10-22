<script lang="ts" setup>
import { computed, nextTick, reactive, ref } from "vue";
import {
    NForm,
    NGrid,
    NFormItemGi,
    NInput,
    NSelect,
    NSpace,
    NTimePicker,
    NDynamicTags,
    NAutoComplete,
    AutoCompleteInst,
FormRules,
FormInst,
FormValidationError,
NInputNumber,
} from "naive-ui";
import { watch } from "vue";
import Message from "../Message.vue";
import GroupService from "../../services/GroupService";
import { User } from "../../types";
import { format } from "date-fns";
import useRedirect from "../../composables/useRedirect";

interface NewGroup {
    name: string;
    meetingDay: string;
    meetingStart: number;
    meetingEnd: number;
    repeat: string;
    age: string;
    leaders: {
        label: string;
        value: User;
    }[];
    member_count: number;
}

const props = defineProps<{
    ageGroups: string[];
    weekDays: string[];
    users: User[];
}>();

const DEFAULT_GROUP = {
    name: "",
    meetingDay: props.weekDays[0],
    meetingStart: 54000000,
    meetingEnd: 57600000,
    repeat: "",
    age: props.ageGroups[0],
    leaders: [],
    member_count: 1,
}

const newGroup = reactive<NewGroup>(DEFAULT_GROUP);

const formRef = ref<FormInst | null>(null);

const { redirect } = useRedirect();

const messages = reactive<{
    error?: string;
    success?: string
}>({
    error: undefined,
    success: undefined,
});

const loading = ref(false);

const ageGroupOptions = computed(() =>
    props.ageGroups.map((v) => ({ label: v, value: v }))
);
const weekDayOptions = computed(() =>
    props.weekDays.map((v) => ({ label: v, value: v }))
);

const formRules: FormRules  = {
    name: [
        {
            required: true,
            trigger: ['blur', 'input'],
            message: 'Nimi vaaditaan'
        }
    ],
    meetingDay: [
        {
            required: true,
            trigger: ['blur', 'change'],
            validator(_rule, day: string){
                if(!props.weekDays.includes(day)){
                    return Error('Viikonpäivä ei ole oikea')
                }
            }
        }
    ],
    meetingStart: [
        {
            required: true,
            trigger: ['blur', 'change'],
            validator(_rule, value: number){
                //before meetingEnd
                if(value && newGroup.meetingEnd && value >= newGroup.meetingEnd){
                    return Error('Kokous alkaa ennen kuin se loppuu')
                }
                
            }

        }
    ],
    meetingEnd: [
        {
            required: true,
            trigger: ['blur', 'change'],
            validator(_rule, value: number){
                //after meetingStart
                if(value && newGroup.meetingStart && value <= newGroup.meetingStart){
                    return Error('Kokous loppuu ennen kuin se alkaa')
                }
            }
        }
    ],
    repeat: [
        {
            required: true,
            trigger: ['blur', 'change'],
            message: 'Kokoontumis aika vaaditaan'
        }
    ],
    age: [
        {
            required: true,
            trigger: ['blur', 'change'],
            message: 'Ikäryhmä vaaditaan',
            validator(_rule, value: string){
                if(!props.ageGroups.includes(value)){
                    return Error('Ikäryhmä ei ole oikea')
                }
            }
        }
    ],
    leaders: [
        {
            required: true,
            trigger: ['blur', 'change'],
            message: 'Vähintään yksi johtaja vaaditaan',
            validator(_rule, value: {label: string; value: number}[]){
                if(value.length < 1){
                    return Error('Vähintään yksi johtaja vaaditaan')
                }
            }
        }
    ],
    member_count: [
        {
            required: true,
            trigger: ['blur', 'change'],
            message: 'Jäsenmäärä vaaditaan',
            validator(_rule, value: number){
                if(value < 1){
                    return Error('Jäsenmäärä ei voi olla pienempi kuin 1')
                }
            }
        }
    ]
}

const onSubmit = (e: MouseEvent) => {
    e.preventDefault();
    formRef.value?.validate(
        (errors: Array<FormValidationError> | undefined) => {
            if (!errors) {
                loading.value = true;
                const newGroupObject = {
                    name: newGroup.name,
                    meeting_day: newGroup.meetingDay,
                    meeting_start: format(newGroup.meetingStart, "H:mm"),
                    meeting_end: format(newGroup.meetingEnd, "H:mm"),
                    repeat: newGroup.repeat,
                    age: newGroup.age,
                    leaders: newGroup.leaders.map((leader) => leader.value),
                    member_count: newGroup.member_count,
                };
                GroupService.storeGroup(newGroupObject).then(response => {
                    messages.success = response.message
                    loading.value = false;
                    redirect("/groups");
                })
                .catch(error => {
                    console.log(error)
                    messages.error = error.response.data.message
                    loading.value = false;
                })
            }
        }
    );
};

const autoCompleteInstRef = ref<AutoCompleteInst | null>(null);
watch(autoCompleteInstRef, (value) => {
    if (value) nextTick(() => value.focus());
});
const leaderInput = ref("");

const leaderOptions = computed(() => {
    if (!leaderInput.value) return [];
    return props.users
        .filter(
            (user) =>
                user.name
                    .toLowerCase()
                    .includes(leaderInput.value.toLowerCase()) &&
                !newGroup.leaders.find(
                    (leader) => leader.value.id === user.id
                )
        )
        .map((user) => ({
            label: user.name,
            value: user.id,
        }));
});

const created = (id) => {
    const user = props.users.find((user) => user.id === id);
    if (user) {
        return {
            label: user.name,
            value: user
        };
    }
};
</script>
<template>
    <n-space vertical>
        <n-form
            :model="newGroup"
            :style="{
                maxWidth: '640px',
            }"
            :rules="formRules"
            ref="formRef"
        >
            <n-grid :span="24" :x-gap="6">
                <n-form-item-gi span="24" label="Nimi" path="name">
                    <n-input v-model:value="newGroup.name" placeholder="Nimi" />
                </n-form-item-gi>

                <n-form-item-gi span="24" label="Kokouspäivä" path="meetingDay">
                    <n-select
                        v-model:value="newGroup.meetingDay"
                        :options="weekDayOptions"
                    />
                </n-form-item-gi>

                <n-form-item-gi
                    span="12"
                    label="Kokous alkaa"
                    path="meetingStart"
                >
                    <n-time-picker
                        :style="{
                            width: '100%',
                        }"
                        placeholder="Valitse aika"
                        format="H:mm"
                        v-model:value="newGroup.meetingStart"
                    />
                </n-form-item-gi>
                <n-form-item-gi
                    span="12"
                    label="Kokous loppuu"
                    path="meetingEnd"
                >
                    <n-time-picker
                        :style="{
                            width: '100%',
                        }"
                        placeholder="Valitse aika"
                        format="H:mm"
                        v-model:value="newGroup.meetingEnd"
                    />
                </n-form-item-gi>

                <n-form-item-gi span="24" label="Kokoontuu" path="repeat">
                    <n-input
                        v-model:value="newGroup.repeat"
                        placeholder="Viikottain..."
                    />
                </n-form-item-gi>
                <n-form-item-gi span="24" label="Jäsenmäärä" path="member_count">
                    <n-input-number
                        v-model:value="newGroup.member_count"
                    />
                </n-form-item-gi>
                <n-form-item-gi span="24" label="Ikäryhmä" path="age">
                    <n-select
                        v-model:value="newGroup.age"
                        :options="ageGroupOptions"
                    />
                </n-form-item-gi>
                <n-form-item-gi span="24" label="Johtajat" path="leaders">
                    <n-dynamic-tags
                        v-model:value="newGroup.leaders"
                        @create="created"
                        @update:value="updated"
                    >
                        <template #input="{ submit, deactivate }">
                            <n-auto-complete
                                ref="autoCompleteInstRef"
                                v-model:value="leaderInput"
                                size="small"
                                :options="leaderOptions"
                                placeholder="Nimi"
                                :clear-after-select="true"
                                @select="
                                    ($event) => {
                                        submit($event);
                                        leaderInput = '';
                                    }
                                "
                                @blur="deactivate"
                            />
                        </template>
                        <template #trigger="{ activate, disabled }">
                            <n-button
                                size="small"
                                type="primary"
                                dashed
                                :disabled="disabled"
                                @click="activate()"
                            >
                                Uusi johtaja
                            </n-button>
                        </template>
                    </n-dynamic-tags>
                </n-form-item-gi>
                <n-form-item-gi span="24">
                    <n-button :loading="loading" type="primary" @click="onSubmit"
                        >Tallenna</n-button
                    >
                </n-form-item-gi>
            </n-grid>
        </n-form>
        <message :messages="messages"/>
    </n-space>
</template>
