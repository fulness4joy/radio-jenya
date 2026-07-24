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
    audio: {
        type: String,
        required: true,
    },
    like: {
        type: String,
        required: true,
    },
    time: {
        type: String,
        required: true,
    },
});


</script>

<template>
    <div class="
        bg-red rounded-xl shadow-md
    ">
        <img v-if="image" :src="image" class="w-auto h-20">

        <h1>
            *********************{{ title }}
        </h1>
        <h3>
            {{ description }}
        </h3>
        <audio controls>
            <source :src="audio"></source>
        </audio>
        <h3>
            {{ like }}
        </h3>
        <h3>
            {{ time }}
        </h3>
    </div>
</template>