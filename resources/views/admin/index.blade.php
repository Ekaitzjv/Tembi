@extends('layouts.app')

@section('content')
@include('admin.panel')
<div class="admin-content">
    <div class="admin-dates">
        <table class="center">
            <tbody>
                <tr>
                    <th>Imagenes totales</th>
                    <td>{{count($images)}}</td>
                </tr>
                <tr>
                    <th>Usuarios totales</th>
                    <td>{{count($users)}}</td>
                </tr>
                <tr>
                    <th>Likes totales</th>
                    <td>{{count($likes)}}</td>
                </tr>
                <tr>
                    <th>Comentarios totales</th>
                    <td>{{count($comments)}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection