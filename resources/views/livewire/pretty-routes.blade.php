<div x-data="{
    scrollWidth: 0,
    syncScroll(e) {
        this.$refs.tableContainer.scrollLeft = e.target.scrollLeft;
    },
    syncTableScroll(e) {
        this.$refs.footerScroll.scrollLeft = e.target.scrollLeft;
    },
    updateWidth() {
        this.scrollWidth = this.$refs.tableContent.scrollWidth;
    }
}" x-init="updateWidth(); new ResizeObserver(() => updateWidth()).observe($refs.tableContent)">
    <div class="w-full px-6 pt-2 pb-20">
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-baseline space-x-3">
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Pretty Routes Extended</h1>
                <span
                    class="text-xs font-medium text-gray-400 uppercase tracking-widest bg-gray-50 px-2 py-0.5 rounded border border-gray-100">
                    Showing {{ count($routes) }} of {{ $totalCount }}
                </span>
            </div>

            @if(config('pretty-routes-extended.back_to_system_url'))
                <a href="{{ config('pretty-routes-extended.back_to_system_url') }}"
                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                    <svg class="-ml-1 mr-1.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ config('pretty-routes-extended.back_to_system_label', 'Back') }}
                </a>
            @endif
        </div>

        <div class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-4 mb-6 items-end">
            <div class="w-full md:w-auto">
                <label for="filter"
                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Filter
                    Prefix</label>
                <select id="filter" wire:model.live="filter"
                    class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm rounded-md px-3 py-2 bg-white shadow-sm transition-all text-gray-700">
                    <option value="all">All Routes</option>
                    @foreach($filterOptions as $option)
                        <option value="{{ $option }}">{{ $option }}</option>
                    @endforeach
                </select>
            </div>

            <div class="w-full md:w-auto">
                <label for="searchField"
                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Search By</label>
                <select id="searchField" wire:model.live="searchField"
                    class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm rounded-md px-3 py-2 bg-white shadow-sm transition-all text-gray-700">
                    <option value="uri">URL Path</option>
                    <option value="name">Route Name</option>
                    <option value="action">Controller Action</option>
                </select>
            </div>

            <div class="flex-grow w-full">
                <label for="search"
                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Keyword
                    Search</label>
                <input type="text" id="search" wire:model.live.debounce.300ms="search" placeholder="Filter routes..."
                    class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm rounded-md shadow-sm px-3 py-2 transition-all">
            </div>
        </div>

        <div x-ref="tableContainer" @scroll="syncTableScroll"
            class="shadow ring-1 ring-black ring-opacity-5 md:rounded-lg overflow-hidden overflow-x-auto bg-white">
            <table x-ref="tableContent" class="min-w-full divide-y divide-gray-300 table-fixed">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="w-20 px-4 py-3 text-left text-xs font-bold text-gray-900 uppercase tracking-widest border-b">
                            Methods</th>
                        <th scope="col"
                            class="w-[60%] px-4 py-3 text-left text-xs font-bold text-gray-900 uppercase tracking-widest border-b">
                            Path</th>
                        <th scope="col"
                            class="w-[12%] px-4 py-3 text-left text-xs font-bold text-gray-900 uppercase tracking-widest border-b">
                            Name</th>
                        <th scope="col"
                            class="w-[4%] px-4 py-3 text-left text-xs font-bold text-gray-900 uppercase tracking-widest border-b">
                            Action</th>
                        <th scope="col"
                            class="w-[12%] px-4 py-3 text-left text-xs font-bold text-gray-900 uppercase tracking-widest border-b">
                            Middleware</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($routes as $route)
                        @php
                            $isHighlighted = in_array($route->id, $selectedRows);
                        @endphp
                        <tr wire:click="toggleRow({{ $route->id }})"
                            class="cursor-pointer transition-all duration-150 {{ $isHighlighted ? 'bg-indigo-50 ring-2 ring-inset ring-indigo-500 z-10' : 'hover:bg-gray-50' }}">
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                <div class="flex flex-wrap gap-1">
                                    @foreach (explode('|', $route['method']) as $method)
                                                            <span
                                                                class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-black leading-3 {{
                                        match ($method) {
                                            'GET' => 'bg-emerald-100 text-emerald-800',
                                            'POST' => 'bg-sky-100 text-sky-800',
                                            'PUT', 'PATCH' => 'bg-amber-100 text-amber-800',
                                            'DELETE' => 'bg-rose-100 text-rose-800',
                                            default => 'bg-slate-100 text-slate-800'
                                        }
                                                                                                                                                        }}">
                                                                {{ $method }}
                                                            </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-4 py-3 text-[13px] text-gray-900 font-mono whitespace-nowrap">
                                {!! preg_replace('#({[^}]+})#', '<span class="text-indigo-600 font-bold bg-indigo-50 px-0.5 rounded">$1</span>', $route->uri) !!}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-[13px] text-gray-600 truncate">
                                {{ $route->name ?: '-' }}
                            </td>
                            <td class="px-4 py-3 text-[13px] text-gray-500">
                                <div class="truncate italic" title="{{ $route->action }}">
                                    {{ class_basename($route->action) }}
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-400">
                                <div class="flex flex-wrap gap-1">
                                    @php
                                        $mws = array_filter(array_map('trim', explode(',', $route->middleware)));
                                    @endphp
                                    @foreach($mws as $mw)
                                        @php
                                            $displayName = str_contains($mw, '\\') ? class_basename($mw) : $mw;
                                        @endphp
                                        <span title="{{ $mw }}"
                                            class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-gray-50 text-gray-500 border border-gray-100 cursor-default transition-all hover:bg-gray-100 hover:text-gray-700">
                                            {{ $displayName }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5"
                                class="px-6 py-12 whitespace-nowrap text-sm text-gray-400 text-center italic font-medium">
                                No matching routes found for current filters.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Sticky Footer with Mirrored Scroll -->
    <div class="fixed bottom-0 left-0 right-0 z-40 bg-white/80 backdrop-blur-md border-t border-gray-200">
        <div x-ref="footerScroll" @scroll="syncScroll"
            class="overflow-x-auto h-2 scrollbar-thin scrollbar-thumb-gray-300">
            <div :style="`width: ${scrollWidth}px`" class="h-1"></div>
        </div>
        <div class="max-w-full px-6 py-3 flex justify-between items-center bg-white/50">
            <div class="flex items-center space-x-4">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-widest">
                    Showing <span class="text-indigo-600 ml-1">{{ count($routes) }}</span> <span
                        class="text-gray-400 mx-1">/</span> {{ $totalCount }} total
                </span>
                @if(count($selectedRows) > 0)
                    <span class="h-4 w-px bg-gray-200"></span>
                    <span
                        class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full ring-1 ring-indigo-100 shadow-sm animate-pulse">
                        {{ count($selectedRows) }} selected
                    </span>
                    <button wire:click="$set('selectedRows', [])"
                        class="text-[10px] font-bold text-gray-400 hover:text-rose-500 uppercase transition-colors">
                        Clear
                    </button>
                @endif
            </div>
            @if(config('pretty-routes-extended.show_footer_attribution', true))
                <div class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] pointer-events-auto">
                    <a href="https://github.com/iperamuna" target="_blank"
                        class="text-indigo-500 hover:text-indigo-600 transition-all hover:tracking-[0.3em]">IPERAMUNA</a>
                    <span class="mx-1 text-gray-300">|</span>
                    <span class="text-gray-400">Pretty Routes Extended</span>
                </div>
            @endif
        </div>
    </div>
</div>