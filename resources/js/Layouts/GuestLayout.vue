<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="flex items-center min-h-screen p-6 bg-slate-50">
      <div class="flex-1 h-full  shadow-xl
      max-w-md mx-auto bg-slate-100 p-6 rounded-lg">
        <slot/>
      </div>
    </div>
  </template>
