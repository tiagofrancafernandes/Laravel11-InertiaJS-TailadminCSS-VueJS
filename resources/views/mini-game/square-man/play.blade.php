</body>
</html>
<!DOCTYPE html>
<html lang="en" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Alpine JS</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <script src="https://cdn.tailwindcss.com"></script>

        {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}
        @vite([
            'resources/js/mini-games/square-man/app.js',
        ])

        <script>
            tailwind.config = {
                darkMode: 'selector',
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Figtree', 'ui-sans-serif', 'system-ui', 'sans-serif', "Apple Color Emoji", "Segoe UI Emoji"],
                        }
                    }
                }
            }
        </script>
    </head>
    <body
        class="antialiased bg-white dark:bg-black"
        x-data="gameData"
    >
        <div
            class="w-full"
            x-on:click="whenClickOnGameFild"
        >
            <div class="w-[35%] mx-auto sm:w-3/12 md:w-48 lg:mx-auto my-4">
                <div class="flex flex-col items-start justify-between mb-4">
                    <h5
                        class="text-md font-bold leading-none text-gray-900 dark:text-white"
                    >
                        Score: <span x-text="score"></span>
                    </h5>
                    <h5
                        class="text-md font-bold leading-none text-gray-900 dark:text-white"
                    >
                        Time left: <span x-text="timeLeft"></span>
                    </h5>
                    <h5
                        class="text-md font-bold leading-none text-gray-900 dark:text-white"
                        x-bind:class="{
                            'pt-1': !topMessage,
                        }"
                    >
                        <span x-text="topMessage"></span>
                    </h5>
               </div>

                <div
                    class="grid gap-1"
                    x-bind:class="[
                        `grid-cols-${width}`,
                        `grid-rows-${height}`,
                    ]"
                    x-on:click="whenClickOnGameFild"
                >
                    {{--
                        <div class="flex items-center justify-center bg-slate-900 rounded-sm border border-gray-500 px-2 w-5 h-5">
                            <div class="text-white"></div>
                        </div>
                    --}}

                    <template
                        x-for="square in fieldSize"
                    >
                        <div
                            class="flex items-center justify-center rounded-sm border border-gray-500 px-2 w-5 h-5"
                            x-bind:class="{
                                'bg-slate-900': position !== square,
                                'bg-slate-600': position === square,
                            }"
                        >
                            <div
                                class="text-white"
                                x-html="giftContentFor(square)"
                            ></div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="w-8/12 lg:w-48 lg:mx-auto my-4">
                <div class="flex items-center justify-center">
                    <button
                        type="button"
                        x-on:click="startNewGame"
                        class="px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >
                        Restart

                        <svg class="w-3 h-3 text-white ms-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12.75 8a4.5 4.5 0 0 1-8.61 1.834l-1.391.565A6.001 6.001 0 0 0 14.25 8 6 6 0 0 0 3.5 4.334V2.5H2v4l.75.75h3.5v-1.5H4.352A4.5 4.5 0 0 1 12.75 8z"></path>
                        </svg>
                    </button>
                </div>
                <input
                    class="bg-transparent text-transparent w-4 h-4 ring-0 focus:ring-0 active:ring-0 focus:outline-none outline-none focus:ring-none"
                    x-ref="gameControl"
                    x-on:keyup.prevent.capture="gameControlKeyUpAction"
                    x-on:keydown.prevent.capture="gameControlKeyDownAction"
                    type="text"
                    placeholder=""
                >
            </div>

            <div class="w-10/12 lg:w-48 mx-auto my-4 flex items-center justify-center">
                <div class="w-full max-w-md p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-4">
                        <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Latest Scores</h5>
                        <a href="#" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">
                            View all
                        </a>
                   </div>
                   <div class="flow-root">
                        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                            <template
                                x-for="fakeItem in 8"
                            >
                                <li class="py-3 sm:py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <img class="w-8 h-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-1.jpg" alt="Neil image">
                                        </div>
                                        <div class="flex-1 min-w-0 ms-4">
                                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                Seu Fulano
                                            </p>
                                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                GRID 8x8 | Time limit: 2m
                                            </p>
                                        </div>
                                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                            <span x-text="5 * 4 - fakeItem"></span>
                                        </div>
                                    </div>
                                </li>
                            </template>
                        </ul>
                   </div>
                </div>
            </div>
        </div>
    </body>
</html>
