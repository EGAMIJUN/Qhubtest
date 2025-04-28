@extends('layouts.app')

@section('title', 'Transpotation')

@section('content')

{{-- 投稿表示 + PCメニュー --}}
<div class="container-fluid">
    <div class="row justify-content-center align-items-start mt-3">
        <div class="col-12 col-md-9">
            @forelse($all_posts as $post)
                @include('posts.components.post-card', ['post' => $post])
            @empty
                <p>No posts available.</p>
            @endforelse
        </div>
        <div class="col-md-3 d-none d-md-block ps-md-4">
            @include("posts.components.sidebar-menu")
        </div>
    </div>
</div>

@endsection
