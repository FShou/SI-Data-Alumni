<html>

    <body>
        @foreach ($posts as $post)
        <h1>{{$post->user->alumni->angkatan->tahun_angkatan}}</h1>
        @endforeach
    </body>
</html>
