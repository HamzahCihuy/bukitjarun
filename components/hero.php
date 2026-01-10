<section class="relative overflow-hidden">
    <div
        id="carouselContent"
        class="relative bg-cover bg-center pt-40 pb-40 transition-all duration-700"
        style="min-height:550px;"
    >
        <img
            src="assets/svg/top.svg"
            class="absolute top-0 left-0 w-full z-20 pointer-events-none"
            alt="wave top"
        >

        <button onclick="prevSlide()"
            class="absolute left-4 top-1/2 -translate-y-1/2 bg-[#17FFB2]/80 hover:bg-[#17FFB2] text-white px-3 py-6 rounded-full z-40 transition-colors">
            <i class="fas fa-chevron-left"></i>
        </button>

        <button onclick="nextSlide()"
            class="absolute right-4 top-1/2 -translate-y-1/2 bg-[#17FFB2]/80 hover:bg-[#17FFB2] text-white px-3 py-6 rounded-full z-40 transition-colors">
            <i class="fas fa-chevron-right"></i>
        </button>

        <div class="container mx-24 px-6 md:px-12 relative z-30 text-white">
            <div class="max-w-2xl text-left mt-10 md:mt-0">
                <p id="slidePromo" class="text-lg md:text-xl font-bold italic text-yellow-400 mb-1 uppercase tracking-wider"></p>
                <h2 id="slideTitle" class="text-5xl md:text-7xl font-black leading-tight drop-shadow-lg"></h2>
                <div class="flex items-center gap-3 mt-4">
                    <span id="slideBadge" class="px-3 py-1 text-sm font-bold uppercase tracking-tighter"></span>
                    <span id="slideSubtitle" class=""></span>
                </div>
                <div class="mt-8">
                    <p class="text-sm opacity-70 uppercase tracking-widest" style="opacity:0;"></p>
                    <p class="text-4xl md:text-6xl font-black flex items-start">
                        <span class="text-xl mt-2 mr-1"></span>
                        <span id="slidePrice"></span>
                    </p>
                    <p id="slideDates" class="mt-4 inline-block backdrop-blur-sm px-4 py-1 rounded-sm text-sm italic"></p>
                </div>
            </div>
        </div>

        <div id="dotContainer" class="absolute bottom-16 left-1/2 -translate-x-1/2 z-30 flex gap-2">
        </div>

        <svg 
            class="absolute bottom-0 left-0 w-full z-20 pointer-events-none h-auto" 
            preserveAspectRatio="none"
            viewBox="0 0 1498 48" 
            fill="none" 
            xmlns="http://www.w3.org/2000/svg"
        >
            <g clip-path="url(#clip0_12_2)">
                <path d="M1580.57 -36.788C1572.54 -16.3837 1450.8 22.5854 1000.19 44C516.222 67 -37.5902 93.5833 -254 104L1580.57 104L1580.57 -36.788Z" fill="#17FFB2"/>
                <path d="M-38.6451 -18.8628C-32.0935 -3.66508 67.2855 25.3602 435.141 41.3103C830.23 58.4414 1282.33 78.2414 1459 86L-38.6451 86L-38.6451 -18.8628Z" fill="#17FFB2"/>
            </g>
            <defs>
                <clipPath id="clip0_12_2">
                    <rect width="1498" height="48" fill="white" transform="matrix(-1 0 0 -1 1498 48)"/>
                </clipPath>
            </defs>
        </svg>

    </div>
</section>