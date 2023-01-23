<template>
  <div
    class="h-fit overflow-hidden rounded-lg bg-secondarybg p-3 shadow-md dark:bg-secondarybg_dark"
  >
    <div class="pb-1 text-2xl font-bold">
      <slot name="header" />
    </div>
    <div class="pt-1">
      <slot name="body" />
    </div>
  </div>
</template>
