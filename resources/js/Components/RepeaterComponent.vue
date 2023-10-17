<template>
  <div>
      <div>
          <p class="text-lg font-medium leading-5 text-gray-900" v-show="label" v-text="label"/>
          <p class="text-sm leading-5 text-gray-700" v-show="description" v-text="description"/>
      </div>
    <div class="flex w-full border-t border-gray-300 pb-1.5" v-for="(item, index) in tmpElements" :key="index">
        <template v-for="(struct, indexStruct) in structure">
            <Input
                class="w-1/3"
                :label="$t(struct.label)"
                color="gray-700"
                type="text"
                v-model="item[struct.key]"
                :error = "struct.error"
            />

        </template>

      <DangerButton
          class="mt-8 ml-4"
          type="button"
          hover="red-400"
          color="white"
          @click="() => {tmpElements.pop();}"
          v-text="$t('remove')"
      />
    </div>
    <SecondaryButton
        class="mt-8 ml-4"
        hover="primary-400"
        color="white"
        @click="() => {tmpElements.push({ url: '' });}"
        v-text="$t('add')"
    />

  </div>
</template>
<script setup>

import {ref} from "vue";
import SecondaryButton from "@/Components/buttons/SecondaryButton.vue";
import DangerButton from "@/Components/buttons/DangerButton.vue";
import Input from "@/Components/form/Input.vue";

const props = defineProps({
    elements: {
        type: Array,
        required: true,
    },
    error: {
        type: String,
    },
    label: {
        type: String,
        default: null,
    },
    name: {
        type: String,
        required: true,
    },
    description: {
        type: String,
        default: null,
    },
    structure: {
        type: Object,
        required: true,
    },
});
console.log(props.elements);
const tmpElements = ref(props.elements);
console.log(tmpElements.value);
emit('upload', tmpElements);




</script>
