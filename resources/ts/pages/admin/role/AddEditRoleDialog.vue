<script setup lang="ts">
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components';

import type { RoleProperties } from '@/pages/admin/role/types';

import { requiredValidator } from '@validators';
interface Props {
  isDialogOpen: boolean,
  selectedRole: RoleProperties
}

interface Emit {
  (e: 'update:isDialogOpen', value: boolean): void
  (e: 'roleAddData', value: RoleProperties): void
  (e: 'roleUpdateData', value: RoleProperties): void
}
const props = withDefaults(defineProps<Props>(), {
  selectedRole: () => ({
    id: 0,
    name: '',
    status: '',
  }),
})
//const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const selectedRole = ref<RoleProperties>(structuredClone(toRaw(props.selectedRole)))
watch(props, () => {
  selectedRole.value = structuredClone(toRaw(props.selectedRole))
})
const isFormValid = ref(false)
const refForm = ref<VForm>()
const textOnMachine = ref('')
const textOnLetter = ref('')
const loadings = ref<boolean[]>([]);

// 👉 drawer close
const closeDialog = () => {
  emit('update:isDialogOpen', false)
  selectedRole.value = structuredClone(toRaw(props.selectedRole))

  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {

  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
      loadings.value[0] = true;
      if (selectedRole.value.id > 0) {

        emit('roleUpdateData', selectedRole.value)
      }
      else {

        emit('roleAddData', {
          id: 0,
          name: selectedRole.value.name,
          status: '1'
        })
      }
      loadings.value[0] = false;
      emit('update:isDialogOpen', false)
      nextTick(() => {

        refForm.value?.reset()
        refForm.value?.resetValidation()
      })
    }
  })
}

const handleDialogModelValueUpdate = (val: boolean) => {
  emit('update:isDialogOpen', val)
}
</script>

<template>
  <VDialog :model-value="props.isDialogOpen" @update:model-value="handleDialogModelValueUpdate" max-width="600">

    <VForm ref="refForm" v-model="isFormValid" @submit.prevent="onSubmit">
      <!-- Dialog Content -->
      <VCard :title="(props.selectedRole.name ? 'Edit' : 'Add New') + ' Role'">

        <DialogCloseBtn variant="text" size="small" @click="closeDialog" />

        <VCardText>
          <VRow>
            <VCol cols="12" md="12">
              <VTextField v-model="selectedRole.name" label="Role name" :rules="[requiredValidator]" />
            </VCol>


          </VRow>
        </VCardText>

        <VCardActions>
          <VSpacer />
          <VBtn color="error" @click="closeDialog">
            Close
          </VBtn>
          <VBtn :loading="loadings[0]" :disabled="loadings[0]" type="submit" color="success">
            Save
          </VBtn>
        </VCardActions>
      </VCard>
    </VForm>
  </VDialog>
</template>
