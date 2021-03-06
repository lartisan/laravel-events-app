@extends('layouts.main')

@section('content')
	<div class="movie-info border-b border-blue-800 container mx-auto pt-8 px-4 md:px-8 lg:px-16 pb-16">
		<div class="container flex flex-col md:flex-row md:items-start">
            {{-- <div class="flex-none md:w-2/5 "> --}}
                <img src="{{ $tvshow['poster_path'] }}" alt="parasite" class="w-full md:w-2/5">
            {{-- </div> --}}
            <div class="xl:ml-16 lg:ml-12 md:ml-8 md:w-3/5">
                <h2 class="text-4xl mt-4 md:mt-0 font-semibold">{{ $tvshow['name'] }}</h2>
                <div class="flex flex-wrap items-center text-blue-400 text-sm">
                    <svg class="fill-current text-orange-500 w-4" viewBox="0 0 24 24"><g data-name="Layer 2"><path d="M17.56 21a1 1 0 01-.46-.11L12 18.22l-5.1 2.67a1 1 0 01-1.45-1.06l1-5.63-4.12-4a1 1 0 01-.25-1 1 1 0 01.81-.68l5.7-.83 2.51-5.13a1 1 0 011.8 0l2.54 5.12 5.7.83a1 1 0 01.81.68 1 1 0 01-.25 1l-4.12 4 1 5.63a1 1 0 01-.4 1 1 1 0 01-.62.18z" data-name="star"/></g></svg>
                    <span class="ml-1">{{ $tvshow['vote_average'] }}</span>
                    <span class="mx-2">|</span>
                    <span>{{ $tvshow['first_air_date'] }}</span>
                    <span class="mx-2">|</span>
                    <span>{{ $tvshow['genres'] }}</span>
                    <span class="mx-2">|</span>
                    <span>{{ __(':count Seasons', ['count' => count($tvshow['seasons'])]) }}</span>
                </div>

                {{-- <div class="seasons container mx-auto px-4 py-8 flex flex-col md:flex-row">
                    <div x-data="{ tab: 1 }">
                        <ul class="flex border-blue-800 border-b flex flex-col lg:flex-row">
                            @foreach($tvshow['seasons'] as $season)
                                <li class="text-center mr-1 text-blue-600 hover:text-blue-400">
                                    <a 
                                        @click.prevent="tab = {{ $season['season_number'] }}" 
                                        :class="{ 'border-blue-800 border-l border-t border-r rounded-t text-blue-400': tab === {{ $season['season_number'] }} }"
                                        class="w-full bg-blue-800 hover:bg-blue-700 py-2 px-4 inline-block font-semibold" 
                                        href="#">{{ $season['name'] }}</a>
                                </li>
                            @endforeach
                        </ul>

                        @foreach($tvshow['seasons'] as $season)
                            <div x-show="tab === {{ $season['season_number'] }}" class="mt-4">
                                <small>{{ __('Premiered on :date', ['date' => $season['air_date']]) }}</small>
                                <small class="mx-4">|</small>
                                <small>{{ __(':number Episodes', ['number' => $season['episode_count']]) }}</small>
                                <div class="season-info container mx-auto py-4 flex flex-col md:flex-row">
                                    <div class="season-image md:w-1/5">
                                        <img src="{{ $season['poster_path'] }}" alt="poster" class="md:w-32 md:w-64">
                                    </div>
                                    @if( strlen($season['overview']) > 0 )
                                        <div class="season-overview md:ml-6 md:w-4/5">
                                            <h3 class="font-semibold text-2xl my-4">{{ __('Overview') }}</h3>
                                            <p>{{ $season['overview'] }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div> --}}

                <p class="text-blue-300 mt-8">{{ $tvshow['overview'] }}</p>
                <span class="flex flex-row-reverse"><small class="text-blue-800 mt-4">{{ __('Translation provided by :provider', ['provider' => 'Google Translate']) }}</small></span>

                <div class="crew mt-12">
                    <div class="flex mt-4">
                        @foreach ($tvshow['created_by'] as $crew)
                            <div class="mr-8">
                                <div>{{ $crew['name'] }}</div>
                                <div class="text-sm text-blue-400">Creator</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="trailer" x-data="{ isOpen: false }">
                    @if (count($tvshow['videos']['results']) > 0)
                        <div class="mt-12">
                            <button
                                @click="isOpen = true"
                                class="flex inline-flex items-center bg-orange-500 text-blue-900 rounded font-semibold px-5 py-4 hover:bg-orange-600 transition ease-in-out duration-150"
                            >
                                <svg class="w-6 fill-current" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M10 16.5l6-4.5-6-4.5v9zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
                                <span class="ml-2">{{ __('Play Trailer') }}</span>
                            </button>
                        </div>

                        <template x-if="isOpen">
                            <div
                                style="background-color: rgba(0, 0, 0, .5);"
                                class="fixed z-20 top-0 left-0 w-full h-full flex items-center shadow-lg overflow-y-auto"
                            >
                                <div class="container mx-auto lg:px-32 rounded-lg overflow-y-auto">
                                    <div class="bg-blue-900 rounded">
                                        <div class="flex justify-end pr-4 pt-2">
                                            <button
                                                @click="isOpen = false"
                                                @keydown.escape.window="isOpen = false"
                                                class="text-3xl leading-none hover:text-blue-300">&times;
                                            </button>
                                        </div>
                                        <div class="modal-body px-8 py-8">
                                            <div class="responsive-container overflow-hidden relative" style="padding-top: 56.25%">
                                                <iframe class="responsive-iframe absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/{{ $tvshow['videos']['results'][0]['key'] }}" style="border:0;" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    @endif
                </div>
            </div>
        </div>
    </div> <!-- end tv-info -->

    <div class="tv-cast border-b border-blue-800">
        <div class="container mx-auto px-4 py-16">
            <h2 class="text-4xl font-semibold">{{ __('Cast') }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                @foreach ($tvshow['cast'] as $cast)
                    <div class="mt-8">
                        <a href="{{ route('actors.show', $cast['id']) }}">
                            <img src="{{ $cast['profile_path'] }}" alt="actor1" class="hover:opacity-75 transition ease-in-out duration-150">
                        </a>
                        <div class="mt-2">
                            <a href="{{ route('actors.show', $cast['id']) }}" class="text-lg mt-2 hover:text-gray:300">{{ $cast['name'] }}</a>
                            <div class="text-sm text-blue-400">
                                {{ $cast['character'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div> <!-- end tv-cast -->

    <div class="tv-images" x-data="{ isOpen: false, image: ''}">
        <div class="container mx-auto px-4 py-16">
            <h2 class="text-4xl font-semibold">{{ __('Images') }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                @foreach ($tvshow['images'] as $image)
                    <div class="mt-8">
                        <a
                            @click.prevent="
                                isOpen = true
                                image='{{ 'https://image.tmdb.org/t/p/original/'.$image['file_path'] }}'
                            "
                            href="#"
                        >
                            <img src="{{ 'https://image.tmdb.org/t/p/w500/'.$image['file_path'] }}" alt="image1" class="hover:opacity-75 transition ease-in-out duration-150">
                        </a>
                    </div>
                @endforeach
            </div>

            <div
                style="background-color: rgba(0, 0, 0, .5);"
                class="fixed z-20 top-0 left-0 w-full h-full flex items-center shadow-lg overflow-y-auto"
                x-show="isOpen"
            >
                <div class="container mx-auto lg:px-32 rounded-lg overflow-y-auto">
                    <div class="bg-blue-900 rounded">
                        <div class="flex justify-end pr-4 pt-2">
                            <button
                                @click="isOpen = false"
                                @keydown.escape.window="isOpen = false"
                                class="text-3xl leading-none hover:text-blue-300">&times;
                            </button>
                        </div>
                        <div class="modal-body px-8 py-8">
                            <img :src="image" alt="poster">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end tv-images -->
@endsection