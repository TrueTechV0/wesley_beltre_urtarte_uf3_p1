@extends('layouts.master')
@section('content')

@if(empty($actors))
    <FONT COLOR="red">No se ha encontrado ningun actor  😥😥 </FONT>
@else
    <div align="center">
    <table border="1">
        <tr>
           <th>Nombre</th>
           <th>Apellido</th>
           <th>Fecha de nacimiento</th>
           <th>Pais</th>
           <th>Imagen</th>
        </tr>

        @foreach($actors as $actor)
            <tr>
                <td>{{$actor['name']}}</td>
                <td>{{$actor['surname']}}</td>
                <td>{{$actor['birthdate']}}</td>
                <td>{{$actor['country']}}</td>
                <td><img src="{{ $actor['img_url'] }}" style="width: 200px; height: 200px;" /></td>
            </tr>
        @endforeach
    </table>
</div>
@endif
@endsection