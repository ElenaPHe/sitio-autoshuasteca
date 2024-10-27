<template>
    <button
        class="inline-flex items-center px-4 py-2 bg-[#001E50] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hovertext focus:bg-gray-700 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
    >
        <slot />
    </button>
</template>

<style>
    button:hover {
        color: #0094d2;
    }
</style>
