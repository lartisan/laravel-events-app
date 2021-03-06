<?php

namespace App\ViewModels;

use Carbon\Carbon;
use Spatie\ViewModels\ViewModel;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TvShowViewModel extends ViewModel
{
    public $tvshow;

    public function __construct($tvshow)
    {
        $this->tvshow = $tvshow;
    }

    public function tvshow()
    {
        return collect($this->tvshow)->merge([
            'poster_path' => $this->tvshow['poster_path']
                ? config('services.tmdb.imgPath') . '/w500/' . $this->tvshow['poster_path']
                : 'https://via.placeholder.com/500x750?text=' . $this->tvshow['title'],
            'vote_average' => $this->tvshow['vote_average'] * 10 . '%',
            'first_air_date' => Carbon::parse($this->tvshow['first_air_date'])->format('M d, Y'),
            'genres' => collect($this->tvshow['genres'])->pluck('name')->flatten()->implode(', '),
            'cast' => collect($this->tvshow['credits']['cast'])->take(5)->map(function ($cast) {
                return collect($cast)->merge([
                    'profile_path' => $cast['profile_path']
                        ? config('services.tmdb.imgPath') . '/w300' . $cast['profile_path']
                        : 'https://via.placeholder.com/300x450?text=' . $cast['name'],
                ]);
            }),
            'overview' => GoogleTranslate::trans(
                html_entity_decode($this->tvshow['overview']),
                'ro'
            ),
            'images' => collect($this->tvshow['images']['backdrops'])->take(9),
            'seasons' => collect($this->tvshow['seasons'])->filter(function ($season) {
                return $season['season_number'] !== 0;
            })->map(function ($season) {
                return collect($season)->merge([
                    'poster_path' => $season['poster_path']
                        ? config('services.tmdb.imgPath') . '/w500/' . $season['poster_path']
                        : 'https://via.placeholder.com/500x750?text=' . $season['name'],
                    'air_date' => Carbon::parse($season['air_date'])->format('d M Y'),
                    'overview' => GoogleTranslate::trans(
                        html_entity_decode($season['overview']),
                        'ro'
                    ),
                ]);
            })
        ]);
        // ->only([
        //     'poster_path', 'id', 'genres', 'name', 'vote_average', 'overview', 'first_air_date', 'credits',
        //     'videos', 'images', 'crew', 'cast', 'images', 'created_by', 'seasons'
        // ]);
    }
}
