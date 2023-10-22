<script lang="ts" setup>
import { ClubMoney, GroupWithExpenses } from '@/types';
import Panel from '../Panel.vue';
import { ref, computed } from 'vue';
import UserGroupsTable from '../groups/UserGroupsTable.vue';
import GroupExpenseStats from './expense-stats/GroupExpenseStats.vue';

const props = defineProps<{
    season: string;
    groups: GroupWithExpenses[];
    clubMoney: ClubMoney[];
}>();

const selectedGroup = ref<GroupWithExpenses>(props.groups[0]);

const selectedClubMoney = computed(() => {
    return props.clubMoney.find((clubMoney) => {
        return clubMoney.age_group === selectedGroup.value.parentAgeGroup;
    }) ?? { age_group: selectedGroup.value.parentAgeGroup, amount: 0 };
});
</script>
<template>
    <Panel header="Ryhmän kulut">
        <GroupExpenseStats :group="selectedGroup" :club-money="selectedClubMoney"  />
    </Panel>
    <Panel :header="`Ryhmien kulut ${season}`">
        <UserGroupsTable
            :groups="groups"
            v-model="selectedGroup"
            />
    </Panel>
</template>
