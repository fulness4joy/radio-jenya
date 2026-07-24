<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';






const $page = usePage();
const user = $page.props.auth.user;

const channels = $page.props.channels;
const liked_channels = $page.props.liked_channels;
const tracks = $page.props.tracks;
const liked_tracks = $page.props.liked_tracks;
const liked_tracks_count = $page.props.liked_tracks_count;
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>

            <h2>
                <a href="/">
                    Home
                </a>
            </h2>



            <div class="dashboard-head">
                <img v-if="user.image"
                    :src="'/storage/' + user.image"
                >
                <div v-else class="noimg">
                    no image
                </div>

                <div class="dashboard-info">
                    <h1><b>Name: {{ user.name }}</b></h1>
                    <h4><b>Description: {{ user.description }}</b></h4>
                    <b>Role: {{ user.role }}</b>
                    <b>Email: {{ user.email }}</b>
                    <b>Created at: {{ user.email_verified_at }}</b>
                    <b>Tracks you liked: {{ liked_tracks_count }}</b>
                </div>
            </div>

            <div>
                <h1 class="title text-center hidden sm:block">Favorite channels:</h1>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 p-4">
                    <div
                        v-for="channel in liked_channels"
                        :key="channel.id"
                        class="card"
                    >
                        <img v-if="channel.image" :src="'/storage/' + channel.image" />

                        <div class="card-body">
                            <h2 class="card-title">
                                {{ channel.name }}
                            </h2>

                            <p class="card-description">
                                {{ channel.description }}
                            </p>

                            <Link :href="route('view', channel.id)">
                                Go
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h1 class="title text-center hidden sm:block">Favorite tracks:</h1>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 p-4">
                    <div
                        v-for="track in liked_tracks"
                        :key="track.id"
                        class="card"
                    >
                        <img v-if="track.image" :src="'/storage/' + track.image" />

                        <div class="card-body">
                            <h2 class="card-title">
                                {{ track.name }}
                            </h2>

                            <p class="card-description">
                                {{ track.description }}
                            </p>
<!-- 
                            <Link :href="route('view', channel.id)">
                                Go
                            </Link> -->
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>

    <!-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 mt-5">
    </div> -->
</template>
