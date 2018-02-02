@extends('plantillas.dashboard')

@section('alertas')

@stop

@section('titulo')
Administrador
@stop

@section('menu')
<li class="">
  <a href="{{url('hotel')}}">
    <i class="fa fa-home"></i><span class="link-title">&nbsp;Hotel</span>
  </a>
</li>
<li class="">
  <a href="{{url('edificio')}}">
    <i class="fa fa-building"></i><span class="link-title">&nbsp;Edificios</span>
  </a>
</li>
<li class="">
  <a href="{{url('habitacion')}}">
    <i class="fa fa-hotel"></i><span class="link-title">&nbsp;Habitaciones</span>
  </a>
</li>
@stop
