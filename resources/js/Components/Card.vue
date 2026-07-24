<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    },
    description: {
        type: String,
        default: '',
    },
    image: {
        type: String,
        default: '',
    },
    methods: {
    goToChannel(id) {
        window.location.href = `/channel/${id}`;
    },
    goToRadio(id) {
        window.location.href = `/radio/${id}`;
    }
}
});


</script>

<template>
    <div class="
        bg-red rounded-xl shadow-md
    ">
        <img v-if="image" :src="image" class="w-auto h-20">

        <h1>
            {{ title }}
        </h1>
        <h3>
            {{ description }}
        </h3>
    </div>
</template>