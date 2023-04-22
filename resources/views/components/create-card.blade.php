<div class="py-4 max-w-2xl mx-auto">
    <div class="flex flex-auto flex-col mx-2 items-center sm:px-6 lg:px-8 sm:justify-center items-center">
        <div class="mb-2 border-solid border-gray-200 rounded border shadow-sm w-full">
            <div class="bg-gray-800 font-semibold text-white uppercase px-2 py-3 border-solid border-gray-200">
                {{ $title }}
            </div>
            <div class="p-6 bg-white">
                {{ $slot }}
            </div>
        </div>
    </div>
    </div>
