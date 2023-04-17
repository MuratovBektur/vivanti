<script setup lang="ts">
import { computed, ref, toRefs } from 'vue'

interface IProps {
  color?: string
}
const props = withDefaults(defineProps<IProps>(), {
  // default border and text color
  color: 'black'
})

const { color } = toRefs(props)

const emit = defineEmits(['click'])
</script>

<template>
  <button
    @click="emit('click')"
    class="leading-[1] min-h-[1.25rem] mt-3 px-8 py-3 font-medium bg-transparent border rounded-lg focus:outline-none"
    :style="{
      borderColor: color,
      color: color
    }"
  >
    <div>
      <slot />
    </div>
  </button>
</template>
