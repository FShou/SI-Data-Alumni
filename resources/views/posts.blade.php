@extends('main')

@section('body')
<main class="container mb-5 mt-3">
        <div class="title-page text-center mb-3">
            <h1>Berita</h1>
        </div>
        <div class="row">
            @foreach ($posts as $post)
                <div class="col-4 py-3">
                    <div class="card" style="width: 28vw;">
                        <img src="/storage/{{ $post->foto_post }}" class="card-img-top" alt="{{ $post->judul_post }}"
                            width="28vw" height="200px">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $post->judul_post }}</h5>
                            <h6 class="card-subtitle">by: {{ $post->user->name }}</h6>
                            <p class="card-text text-justify" style="height: 50px">{{ Str::limit($post->isi, 122) }}</p>
                            <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal"
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
                                <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">{{ $post->judul_post }} <br>
                                </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body overflow-y-scroll" style="height: 65vh;">
                                <img src="/storage/{{ $post->foto_post }}" alt="{{ $post->judul_post }}"
                                    style="width:100%;">
                                <p class="fw-bold">by : {{ $post->user->name }}</p>
                                <p class="text-justify">{{ $post->isi }}</p>
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

    <div class="container d-flex justify-content-center align-items-center">
        {{ $posts->links() }}
    </div>
@endsection
