@php
    use Carbon\Carbon; 
@endphp

@extends('main')

@section('body')
<main class="container mb-5 mt-3">
        <div class="title-page text-center mb-3">
            <h1>Berita</h1>
        </div>
        <div class="row">
            @foreach ($posts as $post)
                <div class="col-4 py-3">
                    <div class="card" style="width: 28vw; height: 470px;">
                        <img src="/storage/{{ $post->foto_post }}" class="card-img-top" alt="{{ $post->judul_post }}"
                            width="28vw" height="200px">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-0">{{ Str::limit($post->judul_post, 29) }}</h5>

                            <div class="by" style="height: 40px;">
                                <h6 class="card-text fst-italic mb-0">
                                    {{ \Carbon\Carbon::parse($post->created_at)->format('j F Y') }} Oleh 
                                    {{ Str::limit($post->user->name, 20) }}
                                </h6>
                                <h6 class="card-text fst-italic mb-0">
                                    {{ ($post->user->name === "Admin") ? "" : $post->user->alumni->prodi->nama_prodi }}
                                    {{ ($post->user->name === "Admin") ? "" : $post->user->alumni->angkatan->tahun_angkatan }}
                                </h6>
                            </div>
                            <div class="d-flex align-items-center my-2">
                                <div class="border d-flex align-items-center @if($post->kategori === 'Event') bg-primary @elseif($post->kategori === 'Feedback') bg-success @elseif($post->kategori === 'Loker') bg-warning @endif" style="border-radius: 9px; height: 22px;">
                                    <h6 class="p-2 mt-1 text-light">{{ $post->kategori }}</h6>
                                </div>                                 
                            </div>  
                            <p class="card-text text-justify" style="height: 70px;">{{ Str::limit($post->isi, 120) }}</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal-{{ $post->id }}">Detail</button>
                        </div>
                    </div>
                </div>

                {{-- Modal --}}
                <div class="modal fade text-dark" id="exampleModal-{{ $post->id }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content" style="width: 50vw;">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">{{ $post->judul_post }}
                                    <br></h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body overflow-y-scroll" style="height: 65vh;">
                                <p class="fw-bold fst-italic mb-2">
                                    Diposting pada {{ \Carbon\Carbon::parse($post->created_at)->format('j F Y') }} oleh {{ $post->user->name }}
                                    {{ ($post->user->name === "Admin") ? "" : "- ".$post->user->alumni->prodi->nama_prodi }}
                                    {{ ($post->user->name === "Admin") ? "" : $post->user->alumni->angkatan->tahun_angkatan }}
                                </p>
                                <div class="d-flex align-items-center my-2">
                                    <div class="border d-flex align-items-center @if($post->kategori === 'Event') bg-primary @elseif($post->kategori === 'Feedback') bg-success @elseif($post->kategori === 'Loker') bg-warning @endif" style="border-radius: 9px; height: 22px;">
                                        <h6 class="p-2 mt-1 text-light">{{ $post->kategori }}</h6>
                                    </div>                                 
                                </div>  
                                <img src="/storage/{{ $post->foto_post }}" alt="{{ $post->judul_post }}"
                                    style="width:100%;">
                                <p class="text-justify mt-3">{{ $post->isi }}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- END MODAL --}}
            @endforeach
        </div>
    </main>

@endsection
