<script setup>
import { reactiveOmit } from "@vueuse/core";
import { TagsInputInput, useForwardProps } from "reka-ui";
import { cn } from "@/lib/utils";

const props = defineProps({
  placeholder: { type: String, required: false },
  autoFocus: { type: Boolean, required: false },
  maxLength: { type: Number, required: false },
  asChild: { type: Boolean, required: false },
  as: { type: null, required: false },
  class: { type: null, required: false },
});

const delegatedProps = reactiveOmit(props, "class");

const forwardedProps = useForwardProps(delegatedProps);
</script>

<template>
  <TagsInputInput
    v-bind="forwardedProps"
    :class="
      cn(
        'text-sm rounded-md border-none w-full bg-input focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]',
        props.class,
      )
    "
  />
</template>
