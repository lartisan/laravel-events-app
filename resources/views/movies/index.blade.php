@extends('layouts.main')

@section('content')
	<div class="container mx-auto pt-8 px-4 md:px-8 lg:px-16 pb-16">
		{{-- <div class="trending-movies">
			<h2 class="uppercase tracking-wider text-orange-500 text-lg font-semibold">{{ __('This week\'s trending movies') }}</h2>

			<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
				@foreach ($trendingMovies as $movie)
					<x-movie-card :movie="$movie" />
				@endforeach
			</div>
		</div> --}}
		
		<div class="popular-movies">
			<h2 class="uppercase tracking-wider text-orange-500 text-lg font-semibold">{{ __('Popular Movies') }}</h2>

			<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
				@foreach($popularMovies as $movie)
					<x-movie-card :movie="$movie" />
				@endforeach
			</div>
		</div>

		<div class="now-playing-movies py-24">
			<h2 class="uppercase tracking-wider text-orange-500 text-lg font-semibold">{{ __('Now Playing') }}</h2>

			<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
				@foreach ($nowPlayingMovies as $movie)
					<x-movie-card :movie="$movie" />
				@endforeach
			</div>
		</div>
	</div>
@endsection