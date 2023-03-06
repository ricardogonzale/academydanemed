@extends('layouts.app')

@section('content')
<div class="row" style="padding-left: 20px;">
    <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="panel panel-default">
        <div class="panel-heading">Registro de Evento</div>
        <div class="panel-body">

        <form method="POST" action="{{ route('EventAdd') }}">
                        @csrf
        <div class="form-group">
            <label for="eventName">Evento</label>
            <input type="text" class="form-control" name="eventname" id="eventname" placeholder="Nombre del Evento">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Descripcion</label>
            <textarea class="form-control" name="eventdescription" id="eventdescription" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="eventName">Ubicacion del Evento</label>
            <input type="text" class="form-control" name="eventdir" id="eventdir" placeholder="Dirección del Evento">
        </div>
        <div class="form-group">
            <label for="eventName">Máximo de Cupos</label>
            <input type="text" class="form-control" name="eventmax" id="eventmax" placeholder="Cantidad Máxima de participantes">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Registro del Sorteo</label>
            <hr>
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="eventName">Inicio</label>
                    <div class="input-group date">
                        <input name="starlottery" id="starlottery" type="text" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="eventName">Fin</label>
                    <div class="input-group date">
                        <input name="endlottery" id="endlottery" type="text" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                    </div>
                </div>
            </div>
         </div>
         </div>
         <div class="form-group">
            <label for="exampleInputPassword1">Fecha del Evento</label>
            <hr>
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="eventName">Inicio</label>
                    <div class="input-group date">
                        <input name="starevent" id="starevent" type="text" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="eventName">Fin</label>
                    <div class="input-group date">
                        <input name="endevent" id="endevent" type="text" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                    </div>
                </div>
            </div>
         </div>
         </div>
        <button type="submit" class="btn btn-default">Registrar</button>
        <button type="button" class="btn btn-primary" onclick="location.href='/event/admin'">Volver</button>
        </form>
    </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $('.input-group.date').datepicker({
        language: "es"
    });
      </script>
@endsection