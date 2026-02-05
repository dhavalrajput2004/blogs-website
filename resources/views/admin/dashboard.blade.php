@extends('layouts.app')
<div>
    <!-- The biggest battle is the war against ignorance. - Mustafa Kemal Atatürk -->
    <x-header />

    @if (Auth::check())
        <p>Last Activity: {{ Auth::user()->last_activity->diffForHumans() }}</p>
        <p> Tota likes on your posts: {{ $likes }} </p>
        <p> Total comments on your posts: {{ $comments }} </p>
        <p> Last week Likes received: {{ $likesweek }} </p>
    @endif
</div>
