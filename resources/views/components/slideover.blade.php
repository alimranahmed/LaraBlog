@props(['body' => '', 'message' => ''])
<!-- This example requires Tailwind CSS v2.0+ -->
<div class="fixed inset-0 overflow-hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true"
     x-show="show_slideover" x-transition.opacity.duration.500ms>
    <div class="absolute inset-0 overflow-hidden">

        <div class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">

            <div class="relative w-screen max-w-md">

                <div class="h-full flex flex-col py-6 bg-white shadow-xl overflow-y-scroll">
                    <!-- Heading -->
                    <section class="px-4 sm:px-6 flex justify-between">
                        <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">
                            {{$heading}}
                        </h2>

                        <div class="">
                            <button type="button" x-on:click="show_slideover = !show_slideover"
                                    class="rounded-md text-gray-800 hover:text-red-800 focus:outline-none focus:ring-2 focus:ring-white">
                                <span class="sr-only">Close panel</span>
                                <!-- Heroicon name: outline/x -->
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </section>
                    <!-- End Heading -->

                    <!--Body-->
                    <section class="mt-6 relative flex-1 px-4 sm:px-6">
                        <!-- Replace with your content -->
                        <div class="absolute inset-0 px-4 sm:px-6">
                            {{$body}}
                            <div class="h-full border-2 border-dashed border-gray-200" aria-hidden="true">

                            </div>
                        </div>
                    </section>
                    <!-- /End body -->

                    <!-- Footer -->
                    <section class="mt-6 px-4 sm:px-6">
                        {{$footer ?? ''}}
                    </section>
                    <!-- End Footer -->
                </div>
            </div>
        </div>
    </div>
</div>
