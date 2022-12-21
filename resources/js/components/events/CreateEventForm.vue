<script lang="ts" setup>
import { reactive, ref } from 'vue'
import { FormInst, FormRules, NButton, NForm, NFormItem, NInput } from 'naive-ui'

const formRef = ref<FormInst | null>(null)

const formData = reactive({

});

const rules: FormRules = {

}

const handleCreateClick = () => { 

 }
</script>
<template>
    <n-form
      ref="formRef"
      inline
      :label-width="80"
      :model="formData"
      :rules="rules"
    >
      <n-form-item label="Name" path="user.name">
        <n-input v-model:value="formData.user.name" placeholder="Input Name" />
      </n-form-item>
      <n-form-item>
        <n-button @click="handleCreateClick">
          Luo tapahtuma
        </n-button>
      </n-form-item>
    </n-form>
  </template>