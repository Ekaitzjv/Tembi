@extends('layouts.app')

@section('content')
@include('admin.panel')
<div class="admin-content">
    <div class="report-container">
        <h4>Reports</h4>
        <!--Bucle de reportes-->
        <table>
            <tr>
                <th>Imagen</th>
                <th>Datos denunciado</th>
                <th>Datos denunciante</th>
                <th>Borrar publicación</th>
                <th>Borrar cuenta</th>
                <th>Cancelar</th>
            </tr>
            @each('admin.report', $report , 'report')
        </table>
    </div>
</div>
@endsection