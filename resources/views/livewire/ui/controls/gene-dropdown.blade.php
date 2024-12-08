<div x-data="{ open: false, search: @entangle('search'), selectOption(option) { console.log('Option clicked:', option); this.search = option; this.open = false; $wire.select(option); } }" class="w-full max-w-xs mx-auto">
    <label for="dropdown" class="block text-sm font-medium text-gray-300">Select a Gene</label>
    <div class="relative mt-1">
        <input type="text" x-model="search" @focus="open = true" @blur="setTimeout(() => open = false, 100)" placeholder="Search..." class="mt-1 block w-full pl-3 pr-10 py-2 text-base bg-gray-800 border-gray-600 text-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
        <div x-show="open" class="absolute z-10 mt-1 w-full bg-gray-800 shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
            <template x-for="option in $wire.options.filter(option => option.toLowerCase().includes(search.toLowerCase()))" :key="option">
                <div @click="selectOption(option)" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-indigo-600 hover:text-white">
                    <span x-text="option" class="block truncate text-white"></span>
                </div>
            </template>
        </div>
    </div>
</div>