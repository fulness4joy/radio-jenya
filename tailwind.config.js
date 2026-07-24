import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: "#0d6efd",
                danger: "#dc3545",
                dangerHover: "#fc5565",
                success: "#198754",
                warning: "#ffc107",
            },
        },
    },

    plugins: [forms],
};






// export default {
//     content: [
//         './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
//         './storage/framework/views/*.php',
//         './resources/views/**/*.blade.php',
//         './resources/js/**/*.vue',
//     ],

//     theme: {
//         extend: {
//             fontFamily: {
//                 sans: ['Figtree', ...defaultTheme.fontFamily.sans],
//             },
//             colors: {
//                 primary: "#0d6efd",
//                 danger: "#dc3545",
//                 dangerHover: "#fc5565",
//                 success: "#198754",
//                 warning: "#ffc107",
//             },
//         },
//     },

//     plugins: [forms],
//     data() {
//       return {
//         currentAudioName: '',
//         audioList: [
//           {
//             src: 'http://music.163.com/song/media/outer/url?id=317151.mp3', // Required
//             title: 'Audio Title 1', // Optional，Phone lock screen music player display
//             artist: 'Artist Name 1', // Optional，Phone lock screen music player display
//             album: 'Album Name 1', // Optional，Phone lock screen music player display
//             artwork: [
//               {
//                 src: 'https://upload.jianshu.io/users/upload_avatars/1696356/c358e43854eb?imageMogr2/auto-orient/strip|imageView2/1/w/96/h/96/format/webp',
//                 sizes: '512x512',
//                 type: 'image/jpg',
//               },
//             ], // Optional，Phone lock screen music player display
//           },
//           {
//             src: 'http://downsc.chinaz.net/Files/DownLoad/sound1/201906/11582.mp3', // Required
//             title: 'Audio Title 2', // Optional，Phone lock screen music player display
//           },
//         ],
//       }
//     },
  
//     methods: {
//       // Use this function if you want to do something before you start playing
//       handleBeforePlay(next) {
//         this.currentAudioName =
//           this.audioList[this.$refs.audioPlayer.currentPlayIndex].title
  
//         next() // Start play
//       },
//     },
//   }