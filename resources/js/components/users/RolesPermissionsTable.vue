<script lang="ts" setup>
import { Permission, Role } from '@/types';
import {NTable} from 'naive-ui';

defineProps<{
    roles: Role[];
    permissions: Permission[];
}>();

function hasPermission(role: Role, permission: Permission) {
    return role.permissions.some((p) => p.id === permission.id);
}

</script>
<template>
<n-table :bordered="false" :single-line="false">
  <thead>
    <tr>
        <th></th>
      <th v-for="role in roles" :key="role.id">{{ role.name }}</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="permission in permissions" :key="permission.id">
    <td>{{ permission.name }}</td>
      <td v-for="role in roles" :key="role.id">
        <!-- Render 'x' if the permission matches the role -->
        <span v-if="hasPermission(role, permission)">
          x
        </span>
      </td>
    </tr>
  </tbody>
</n-table>

</template>
