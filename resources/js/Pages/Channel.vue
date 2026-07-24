<script setup>
import { Head, Link, usePage, router } from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';
import CardAudio from '@/Components/CardAudio.vue';
import { VueSound } from 'vue-sound'
import { nextTick, ref, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    channel: Object,
    tracks: Array,
    time_start: Number
});

function toggleLike($id) {
    router.post(route('likes', $id), {}, {});
}

function toggleLikeTrack($id) {
    router.post(route('tracks_likes', $id), {}, {});
}

// function startRadio(id) {
//     window.location.href=`/channel/radio/`+id;
//     router.get(route('radio', {id}), {}, {});
// }

function startRadio() {
    const audio_player = document.getElementById('radio_player');
    alert(audio_player.currentTime);
    
    const currentTime = Math.floor(Date.now() / 1000);
    const elapsedTime = currentTime - props.time_start;
    
    const allTime = props.tracks.reduce((sum, track) => sum + track.time, 0);
    
    const playTime = elapsedTime % allTime;
    
    let start = 0;
    let currentTrack = null;
    let currentTrackTime = 0;
    
    for (const track of props.tracks) {
        if (playTime > start && playTime <= start + track.time) {
            currentTrack = track;
            currentTrackTime = playTime - start;
            break;
        }
        start += track.time;
    }
    
    if (currentTrack) {
        audio_player.src = '/storage/' + currentTrack.path;
        // audio_player.currentTime = currentTrackTime;
        // audio_player.play();
        audio_player.onloadedmetadata = () => {
            // audio_player.currentTime = currentTrackTime;
            audio_player.currentTime = 30;
            audio_player.play();
            alert(audio_player.currentTime);
        };
    }
}

function waitForAudioEvent(audio, eventName, timeout = 3000) {
    return new Promise((resolve) => {
        const timer = setTimeout(resolve, timeout);

        audio.addEventListener(eventName, () => {
            clearTimeout(timer);
            resolve();
        }, { once: true });
    });
}

async function startRadio2() {
    const currentTime = Math.floor(Date.now() / 1000);
    const elapsedTime = currentTime - props.time_start;
    
    const allTime = props.tracks.reduce((sum, track) => sum + track.time, 0);

    if (!allTime) {
        return;
    }
    
    const playTime = elapsedTime % allTime;
    
    let start = 0;
    let track = null;
    let trackTime = 0;
    
    for (const t of props.tracks) {
        if (playTime >= start && playTime < start + t.time) {
            track = t;
            trackTime = playTime - start;
            break;
        }
        start += t.time;
    }
    
    if (track) {
        currentTrack.value = track;
        currentTrackTime.value = trackTime;
        await nextTick();

        const audio_player = radio_player.value;

        if (!audio_player) {
            return;
        }

        audio_player.onerror = () => {
            console.error('Audio loading failed:', audio_player.error);
            isPlaying.value = false;
        };

        audio_player.src = '/track/' + track.id + '/stream';
        audio_player.load();

        await waitForAudioEvent(audio_player, 'loadedmetadata');

        const duration = audio_player.duration || track.time;
        const seekTime = Math.min(trackTime, Math.max(duration - 0.25, 0));

        currentTrackTime.value = seekTime;

        if (seekTime > 0) {
            audio_player.currentTime = seekTime;
            await waitForAudioEvent(audio_player, 'seeked');
        }

        try {
            alert('Playing audio...' + audio_player.src + ' at time: ' + audio_player.currentTime);
            await audio_player.play();
            isPlaying.value = true;
        } catch (error) {
            console.error('Audio playback failed:', error);
            isPlaying.value = false;
        }
    }
}

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}

const $page = usePage();
console.log($page.props.auth.user);
const access_admin = $page.props.auth.access_admin;
const tracks = $page.props.tracks;

const radio_player = ref(null);
const currentTrack = ref(null);
const currentTrackTime = ref(0);
const isPlaying = ref(false);
const currentTime = ref(0);
const duration = ref(0);
const progress = ref(0);

function togglePlay() {
    const audio = radio_player.value;
    if (audio.paused) {
        audio.play();
        isPlaying.value = true;
    } else {
        audio.pause();
        isPlaying.value = false;
    }
}

function formatTime(seconds) {
    const mins = Math.floor(seconds / 60);
    const secs = Math.floor(seconds % 60);
    return `${mins}:${secs.toString().padStart(2, '0')}`;
}

function updateProgress() {
    const audio = radio_player.value;
    if (audio) {
        currentTime.value = audio.currentTime;
        duration.value = audio.duration || 0;
        progress.value = (audio.currentTime / audio.duration) * 100 || 0;
    }
}

let progressInterval;

onMounted(() => {
    const audio = radio_player.value;
    if (audio) {
        audio.addEventListener('timeupdate', updateProgress);
        audio.addEventListener('play', () => isPlaying.value = true);
        audio.addEventListener('pause', () => isPlaying.value = false);
    }
});

onUnmounted(() => {
    const audio = radio_player.value;
    if (audio) {
        audio.removeEventListener('timeupdate', updateProgress);
    }
    if (progressInterval) {
        clearInterval(progressInterval);
    }
});

</script>



<template>
    <Head title="Channel" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

                <header
                    class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3
                            bg-pastel-bg text-pastel-text
                            bg-pastel-primary"
                >
                    <!-- ЛОГО -->
                    <div class="nav-logo">
                        MyApp
                    </div>

                    <!-- НАВИГАЦИЯ -->
                    <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Dashboard
                        </Link>

                        <div v-else>
                            <Link
                                :href="route('login')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Log in
                            </Link>

                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Register
                            </Link>
                        </div>
                    </nav>
                </header>


                <div class="bg-pastel-bg text-pastel-text">

                    <div class="audio-head">
                        <img :src="'/storage/' + channel.image">

                        <div class="info">
                            <h1><b>{{ channel.name }}</b></h1>
                            <h4><b>{{ channel.description }}</b></h4>

                            <button type="button" name="like" class="bg-gray-700 m-4 text-white" @click="toggleLike( channel.id )">Like</button>
                            Likes: {{ channel.likes_count }}
                            <button @click="startRadio2">Radio</button>
                        </div>

                        <!-- Player Zone -->
                        <div class="player-zone" v-if="currentTrack">
                            <div class="player-content">
                                <img :src="'/storage/' + currentTrack.image" class="track-image" alt="Track Image">
                                <div class="track-info">
                                    <h3>{{ currentTrack.name }}</h3>
                                    <p>{{ currentTrack.description }}</p>
                                    <div class="wave-animation">
                                        <div class="wave-bar"></div>
                                        <div class="wave-bar"></div>
                                        <div class="wave-bar"></div>
                                        <div class="wave-bar"></div>
                                        <div class="wave-bar"></div>
                                        <div class="wave-bar"></div>
                                        <div class="wave-bar"></div>
                                        <div class="wave-bar"></div>
                                    </div>
                                    <audio ref="radio_player"></audio>
                                    <div class="custom-player">
                                        <div class="play-btn" @click="togglePlay">
                                            <span v-if="!isPlaying">▶</span>
                                           <span v-else>⏸</span>
                                        </div>
                                        <div class="progress-container">
                                            <div class="progress-bar" :style="{ width: progress + '%' }"></div>
                                        </div>
                                        <span class="time-display">{{ formatTime(currentTime) }} / {{ formatTime(duration) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>



                    
                    <div class="audio-body">

                        <div v-for="track in tracks" class="audio">
                            <vue-sound
                                livestream
                                show-download

                                :title="track?.name"
                                :description="track?.description"
                                :image="track ? '/storage/' + track.image : ''"
                                :file="track ? '/storage/' + track.path : ''"
                                :like="track?.tracks_likes_count"
                                :time="track?.time"
                            />
                            <button type="button" name="track_like" class="bg-gray-700 m-4 text-white" @click="toggleLikeTrack( track.id )">Like</button>
                            Likes: {{ track.likes_count }}
                        </div>

                    </div>
                </div>
</template>
