<script lang="ts" setup>
import { computed, nextTick, ref } from "vue";
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
} from "naive-ui";
import { watch } from "vue";

interface NewGroup {
    name: string;
    meetingDay: string;
    meetingStart: string | null;
    meetingEnd: string | null;
    repeat: string;
    age: string;
    leaders: {
        label: string;
        value: number;
    }[];
}

const props = defineProps<{
    ageGroups: string[];
    weekDays: string[];
    users: {
        id: number;
        name: string;
    }[];
}>();

const newGroup = ref<NewGroup>({
    name: "",
    meetingDay: props.weekDays[0],
    meetingStart: null,
    meetingEnd: null,
    repeat: "",
    age: props.ageGroups[0],
    leaders: [],
});

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
            message: 'Nimi vaaditaan'
        }
    ],
    meetingDay: [
        {
            required: true,
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
            validator(_rule, value: string){
                //before meetingEnd
                
            }

        }
    ]
}

const onSubmit = () => {
    console.log(newGroup.value);
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
                !newGroup.value.leaders.find(
                    (leader) => leader.value === user.id
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
        >
            <n-grid :span="24" :x-gap="6">
                <n-form-item-gi span="24" label="Ryhmän nimi" path="name">
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
                        format="h:mm"
                        v-model:formatted-value="newGroup.meetingStart"
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
                        format="h:mm"
                        v-model:formatted-value="newGroup.meetingEnd"
                    />
                </n-form-item-gi>

                <n-form-item-gi span="24" label="Kokoontuu" path="repeat">
                    <n-input
                        v-model:value="newGroup.repeat"
                        placeholder="Viikottain..."
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
                    <n-button type="primary" @click="onSubmit"
                        >Tallenna</n-button
                    >
                </n-form-item-gi>
            </n-grid>
        </n-form>
    </n-space>
</template>
