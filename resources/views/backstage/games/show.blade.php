@extends('backstage.templates.backstage')

@section('content')
<div id="card" class="bg-white shadow-lg mx-auto rounded-b-lg">
    <div class="px-10 pt-4 pb-8">

        @if( !empty($game->symbol) and count($game->symbol) > 0)
        <div class="grid grid-cols-5 gap-4 items-start py-2 border-b border-gray-100 mt-5">
            <div class="col-span-1 font-semibold">Symbol</div>
            <div class="col-span-1 font-semibold">Match</div>
            <div class="col-span-1 font-semibold">3-Match Point</div>
            <div class="col-span-1 font-semibold">4-Match Point</div>
            <div class="col-span-1 font-semibold">5-Match Point</div>
        </div>

        @php
        $i = 0;
        @endphp

        @while($i < count($game->symbol))
            @for ($j = 0; $j < count($game->symbol[$i]); $j++)
                <div class="grid grid-cols-5 gap-4 items-start py-2 border-b border-gray-100">
                    <div class="col-span-1"><img width="50"
                            src="{{ asset('storage/'.$game->symbol[$i][$j]['image']) }}"></div>
                    <div class="col-span-1">{{ $game->symbol[$i][$j]['match']}}</div>
                    <div class="col-span-1">{{ $game->symbol[$i][$j]['three_match']}}</div>
                    <div class="col-span-1">{{ $game->symbol[$i][$j]['four_match'] }}</div>
                    <div class="col-span-1">{{ $game->symbol[$i][$j]['five_match']}}</div>
                </div>
                @endfor
                @php
                $i++;
                @endphp
                @endwhile

                @else
                <div class="px-6 py-3 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900 text-center">
                    <span>No data</span>
                </div>
                @endif
    </div>
</div>
@endsection