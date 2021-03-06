<?php

namespace App\Http\Controllers;

use App\ViewModels\MoviesViewModel;
use App\ViewModels\MovieViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trendingMovies = Http::withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.baseUrl') . "/trending/movie/week?language=" . config('services.tmdb.language'))
            ->json()['results'];

        $popularMovies = Http::withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.baseUrl') . "/movie/popular?language=" . config('services.tmdb.language'))
            ->json()['results'];

        $nowPlayingMovies = Http::withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.baseUrl') . "/movie/now_playing?language=" . config('services.tmdb.language') . "&region=" . config('services.tmdb.region'))
            ->json()['results'];

        $genres = Http::withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.baseUrl') . "/genre/movie/list?language=" . config('services.tmdb.language'))
            ->json()['genres'];

        $viewModel = new MoviesViewModel($trendingMovies, $popularMovies, $nowPlayingMovies, $genres);

        // dd($nowPlayingMovies);
        return view('movies.index', $viewModel);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = Http::withToken(config('services.tmdb.token'))
            ->get(
                config('services.tmdb.baseUrl') . "/movie/" . $id . "?append_to_response=credits,videos,images"
            )
            ->json();

        $recommendedMovies = Http::withToken(config('services.tmdb.token'))
            ->get(
                config('services.tmdb.baseUrl') . "/movie/" . $id . "/recommendations"
            )
            ->json()['results'];

        $viewModel = new MovieViewModel($movie, $recommendedMovies);

        // dd($movie);
        return view('movies.show', $viewModel);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
