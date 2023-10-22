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
import { Group, User } from "../../types";
import { format, parse } from "date-fns";
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
    group: Group;
}>();

const editableGroup = reactive<NewGroup>({
    name: props.group.name,
    meetingDay: props.group.meeting_day,
    meetingStart: parse(
        props.group.meeting_start,
        "H:mm",
        new Date()
    ).getTime(),
    meetingEnd: parse(props.group.meeting_end, "H:mm", new Date()).getTime(),
    repeat: props.group.repeat,
    age: props.group.age,
    leaders: props.group.leaders.map((leader) => ({
        label: leader.name,
        value: leader,
    })),
    member_count: props.group.member_count,
});

const formRef = ref<FormInst | null>(null);

const messages = reactive<{
    error?: string;
    success?: string;
}>({
    error: undefined,
    success: undefined,
});

const loading = ref(false);
const deleting = ref(false);

const { redirect } = useRedirect();

const ageGroupOptions = computed(() =>
    props.ageGroups.map((v) => ({ label: v, value: v }))
);
const weekDayOptions = computed(() =>
    props.weekDays.map((v) => ({ label: v, value: v }))
);

const formRules: FormRules = {
    name: [
        {
            required: true,
            trigger: ["blur", "input"],
            message: "Nimi vaaditaan",
        },
    ],
    meetingDay: [
        {
            required: true,
            trigger: ["blur", "change"],
            validator(_rule, day: string) {
                if (!props.weekDays.includes(day)) {
                    return Error("Viikonpäivä ei ole oikea");
                }
            },
        },
    ],
    meetingStart: [
        {
            required: true,
            trigger: ["blur", "change"],
            validator(_rule, value: number) {
                //before meetingEnd
                if (
                    value &&
                    editableGroup.meetingEnd &&
                    value >= editableGroup.meetingEnd
                ) {
                    return Error("Kokous alkaa ennen kuin se loppuu");
                }
            },
        },
    ],
    meetingEnd: [
        {
            required: true,
            trigger: ["blur", "change"],
            validator(_rule, value: number) {
                //after meetingStart
                if (
                    value &&
                    editableGroup.meetingStart &&
                    value <= editableGroup.meetingStart
                ) {
                    return Error("Kokous loppuu ennen kuin se alkaa");
                }
            },
        },
    ],
    repeat: [
        {
            required: true,
            trigger: ["blur", "change"],
            message: "Kokoontumis aika vaaditaan",
        },
    ],
    age: [
        {
            required: true,
            trigger: ["blur", "change"],
            message: "Ikäryhmä vaaditaan",
        },
    ],
    leaders: [
        {
            required: true,
            trigger: ["blur", "change"],
            message: "Vähintään yksi johtaja vaaditaan",
            validator(_rule, value: { label: string; value: number }[]) {
                if (value.length < 1) {
                    return Error("Vähintään yksi johtaja vaaditaan");
                }
            },
        },
    ],
    member_count: [
        {
            required: true,
            trigger: ["blur", "change"],
            message: "Jäsenmäärä vaaditaan",
            validator(_rule, value: number){
                if(value < 1){
                    return Error('Jäsenmäärä ei voi olla pienempi kuin 1')
                }
            }
        },
    ],
};

/**
 * Updates the group
 * @param e
 */
const onSubmit = (e: MouseEvent) => {
    e.preventDefault();
    formRef.value?.validate(
        (errors: Array<FormValidationError> | undefined) => {
            if (!errors) {
                loading.value = true;
                const updatedGroupObject = {
                    name: editableGroup.name,
                    meeting_day: editableGroup.meetingDay,
                    meeting_start: format(editableGroup.meetingStart, "H:mm"),
                    meeting_end: format(editableGroup.meetingEnd, "H:mm"),
                    repeat: editableGroup.repeat,
                    age: editableGroup.age,
                    leaders: editableGroup.leaders.map(
                        (leader) => leader.value
                    ),
                    member_count: editableGroup.member_count
                };
                GroupService.updateGroup(props.group.id, updatedGroupObject)
                    .then((response) => {
                        messages.success = response.message;
                        loading.value = false;
                        redirect('/groups')
                        
                    })
                    .catch((error) => {
                        console.log(error);
                        messages.error = error.response.data.message;
                        loading.value = false;
                    });
            }
        }
    );
};

/**
 * Deletes the group
 */
const onDelete = () => {
    if (!window.confirm("Haluatko varmasti poistaa ryhmän?")) return;
    deleting.value = true;
    GroupService.deleteGroup(props.group.id)
        .then((response) => {
            messages.success = response.message;
            deleting.value = false;
            redirect("/groups");
        })
        .catch((error) => {
            console.log(error);
            messages.error = error.response.data.message;
            deleting.value = false;
        });
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
                !editableGroup.leaders.find(
                    (leader) => leader.value.id === user.id
                )
        )
        .map((user) => ({
            label: user.name,
            value: user.id,
        }));
});

/**
 * Created leader object from id
 * @param id
 */
const created = (id) => {
    const user = props.users.find((user) => user.id === id);
    if (user) {
        return {
            label: user.name,
            value: user,
        };
    }
};
</script>
<template>
    <n-space vertical>
        <n-form
            :model="editableGroup"
            :style="{
                maxWidth: '640px',
            }"
            :rules="formRules"
            ref="formRef"
        >
            <n-grid :span="24" :x-gap="6">
                <n-form-item-gi span="24" label="Nimi" path="name">
                    <n-input
                        v-model:value="editableGroup.name"
                        placeholder="Nimi"
                    />
                </n-form-item-gi>

                <n-form-item-gi span="24" label="Kokouspäivä" path="meetingDay">
                    <n-select
                        v-model:value="editableGroup.meetingDay"
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
                        v-model:value="editableGroup.meetingStart"
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
                        v-model:value="editableGroup.meetingEnd"
                    />
                </n-form-item-gi>

                <n-form-item-gi span="24" label="Kokoontuu" path="repeat">
                    <n-input
                        v-model:value="editableGroup.repeat"
                        placeholder="Viikottain..."
                    />
                </n-form-item-gi>
                <n-form-item-gi span="24" label="Jäsenmäärä" path="member_count">
                    <n-input-number
                        v-model:value="editableGroup.member_count"
                    />
                </n-form-item-gi>
                <n-form-item-gi span="24" label="Ikäryhmä" path="age">
                    <n-select
                        disabled
                        v-model:value="editableGroup.age"
                        :options="ageGroupOptions"
                    />
                </n-form-item-gi>
                <n-form-item-gi span="24" label="Johtajat" path="leaders">
                    <n-dynamic-tags
                        v-model:value="editableGroup.leaders"
                        @create="created"
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
                    <n-space>
                        <n-button
                            :loading="loading"
                            :disabled="deleting"
                            type="primary"
                            @click="onSubmit"
                            >Tallenna</n-button
                        >
                        <n-button
                            class="ms-3"
                            :disabled="loading"
                            :loading="deleting"
                            type="error"
                            @click="onDelete"
                            >Poista</n-button
                        >
                    </n-space>
                </n-form-item-gi>
            </n-grid>
        </n-form>
        <message :messages="messages" />
    </n-space>
</template>
