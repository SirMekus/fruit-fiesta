<div>

    <div id="card" class="bg-white shadow-lg mx-auto rounded-b-lg">
        <div class="px-10 pt-4 pb-8">

            @if($result->count() > 0)
            <table class="min-w-full mt-5">
                <thead>
                    <tr>
                        <th class="table-header">S/N</th>
                        <th class="table-header">Image</th>
                        <th class="table-header">3 Points</th>
                        <th class="table-header">4 Points</th>
                        <th class="table-header">5 Points</th>
                    <tr>
                </thead>
                </tbody class="bg-white">
                @php
                $i = 0;
                $offset = ($result->currentPage() - 1) * $result->perPage();
                @endphp
                
                @foreach ($result as $symbol)
                
                @php
                $i +=1;
                $sn = $offset + $i;
	            @endphp
                <tr class="@if( ($i) % 2 === 0 ) alternate @endif">
                    <td>{{$sn}}.</td>
                    <td class="px-6 py-3 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900">
                        <img width="50" src="{{ asset('storage/'.$symbol->image) }}">
                    </td>
                    <td class="px-6 py-3 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900">{{
                        $symbol->three_match }}</td>
                    <td class="px-6 py-3 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900">{{
                        $symbol->four_match }}</td>
                    <td class="px-6 py-3 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900">{{
                        $symbol->five_match }}</td>
                    <td class="px-6 py-3 whitespace-no-wrap text-left text-sm leading-5 font-medium">
                        <button wire:click="$emit('delete', {{$symbol->id}})" class="table-tool">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                <tr>
                @endforeach
                </tbody>
            </table>
            {{ $result->links() }}
            <hr />
            @endif

            @if($result->count() < 10) <form class="grid" method="post" wire:submit.prevent="save">
                
                <div class='mt-5'>
                    <h1>Add a Symbol</h1>
                </div>
                <div class="grid grid-cols-5 gap-4 items-start">
                    
                    <label for="search" class="thunderbite-label">
                        Symbol
                    </label>

                    <div class="col-span-3">
                        @if ($photo)
                        <img src="{{ $photo->temporaryUrl() }}">
                        @endif

                        <input wire:model="photo" type="file" class="thunderbite-input" name="search" value="">

                        @error('photo') <span class="error">{{ $message }}</span> @enderror

                    </div>
                </div>

                <div class="grid grid-cols-5 gap-4 items-start pt-5">
                    <label for="search" class="thunderbite-label">
                        3-match Point
                    </label>

                    <div class="col-span-3">
                        <input wire:model="point_3" type="number" class="thunderbite-input     " name="search" value="">
                        @error('point_3') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-5 gap-4 items-start pt-5">
                    <label for="search" class="thunderbite-label">
                        4-match Point
                    </label>

                    <div class="col-span-3">
                        <input wire:model="point_4" type="number" class="thunderbite-input     " name="search" value="">
                        @error('point_4') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-5 gap-4 items-start pt-5">
                    <label for="search" class="thunderbite-label">
                        5-match Point
                    </label>

                    <div class="col-span-3">
                        <input wire:model="point_5" type="number" class="thunderbite-input     " name="search" value="">
                        @error('point_5') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-5 gap-4 items-start pt-5">
                    <div class="col-span-3">
                        <input
                            style="background:linear-gradient(0deg, rgba(81, 182, 255, 1) 0%, rgba(78, 147, 255, 1) 90%);"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full"
                            value="Add New Symbol" type="submit" />
                    </div>
                </div>
                </form>
                @endif
        </div>
    </div>
</div>