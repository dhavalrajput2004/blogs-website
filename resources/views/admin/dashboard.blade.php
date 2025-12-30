@extends('layouts.app')
<div>
    <!-- The biggest battle is the war against ignorance. - Mustafa Kemal Atatürk -->
    <x-header />
    Dashboard
    @if (Auth::check())
        <p>Last Activity: {{ Auth::user()->last_activity }}</p>
    @endif
</div>
