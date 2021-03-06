<?php

namespace App\ViewModels;

use Carbon\Carbon;
use Spatie\ViewModels\ViewModel;
use Stichoza\GoogleTranslate\GoogleTranslate;

class ActorViewModel extends ViewModel
{
    public $actor;
    public $social;
    public $credits;

    public function __construct($actor, $social, $credits)
    {
        $this->actor = $actor;
        $this->social = $social;
        $this->credits = $credits;
    }

    public function actor()
    {
        return collect($this->actor)->merge([
            'birthday' => $this->actor['birthday'] ? Carbon::parse($this->actor['birthday'])->format('d M Y') : null,
            'age' => Carbon::parse($this->actor['birthday'])->age,
            'profile_path' => $this->actor['profile_path']
                ? config('services.tmdb.imgPath') . '/w300/' . $this->actor['profile_path']
                : 'https://ui-avatars.com/api/?size=300&name=' . $this->actor['name'],
            'biography' => GoogleTranslate::trans(
                html_entity_decode($this->actor['biography']),
                'ro'
            )
        ]);
        // ->only([
        //     'birthday', 'age', 'profile_path', 'name', 'id', 'homepage', 'place_of_birth', 'biography'
        // ]);
    }

    public function social()
    {
        return collect($this->social)->merge([
            'twitter' => $this->social['twitter_id'] ? 'https://twitter.com/' . $this->social['twitter_id'] : null,
            'facebook' => $this->social['facebook_id'] ? 'https://facebook.com/' . $this->social['facebook_id'] : null,
            'instagram' => $this->social['instagram_id'] ? 'https://instagram.com/' . $this->social['instagram_id'] : null,
        ])->only([
            'facebook', 'instagram', 'twitter',
        ]);
    }

    public function knownForMovies()
    {
        $castMovies = collect($this->credits)->get('cast');

        return collect($castMovies)->sortByDesc('popularity')->take(5)->map(function ($movie) {
            if (isset($movie['title'])) {
                $title = $movie['title'];
            } elseif (isset($movie['name'])) {
                $title = $movie['name'];
            } else {
                $title = 'Untitled';
            }

            return collect($movie)->merge([
                'poster_path' => $movie['poster_path']
                    ? config('services.tmdb.imgPath') . '/w185' . $movie['poster_path']
                    : 'https://via.placeholder.com/185x278?text=' . $title,
                'title' => $title,
                'linkToPage' => $movie['media_type'] === 'movie' ? route('movies.show', $movie['id']) : route('tv.show', $movie['id'])
            ]);
            // ->only([
            //     'poster_path', 'title', 'id', 'media_type', 'linkToPage',
            // ]);
        });
    }


    public function credits()
    {
        $castMovies = collect($this->credits)->get('cast');

        return collect($castMovies)->map(function ($movie) {
            if (isset($movie['release_date'])) {
                $releaseDate = $movie['release_date'];
            } elseif (isset($movie['first_air_date'])) {
                $releaseDate = $movie['first_air_date'];
            } else {
                $releaseDate = '';
            }

            if (isset($movie['title'])) {
                $title = $movie['title'];
            } elseif (isset($movie['name'])) {
                $title = $movie['name'];
            } else {
                $title = __('Untitled');
            }

            return collect($movie)->merge([
                // 'poster_path' => config('services.tmdb.imgPath') . '/w500' . $movie['poster_path'],
                'poster_path' => $movie['poster_path']
                    ? config('services.tmdb.imgPath') . '/w500/' . $movie['poster_path']
                    : 'https://via.placeholder.com/500x750?text=' . $title,
                'vote_average' => $movie['vote_average'] * 10 . '% (' . __('out of') . ' ' .  number_format($movie['vote_count'], 0, ',', '.') . ' ' . __('votes') . ')',
                'genres' => collect($movie['genre_ids'])->pluck('name')->flatten()->implode(', '),
                'release_date' => $releaseDate,
                'release_year' => isset($releaseDate) ? Carbon::parse($releaseDate)->format('Y') : 'Future',
                'title' => $title,
                'character' => isset($movie['character']) ? $movie['character'] : '',
                'linkToPage' => $movie['media_type'] === 'movie' ? route('movies.show', $movie['id']) : route('tv.show', $movie['id']),
                'route' => isset($movie['media_type'])
                    ? ($movie['media_type'] === 'tv'
                        ? route('tv.show', $movie['id'])
                        : route('movies.show', $movie['id']))
                    : route('movies.show', $movie['id'])
            ]);
            // ->only([
            //     'id', 'poster_path', 'vote_average', 'release_date', 'release_year', 'title', 'character', 'linkToPage', 'genres', 'media_type'
            // ]);
        })->sortByDesc('release_date');
    }
}
