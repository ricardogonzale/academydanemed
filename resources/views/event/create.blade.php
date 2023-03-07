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
            <label for="id_event">Identificador del Evento</label>
            <input type="text" class="form-control" name="id_event" id="id_event" placeholder="academi04032023" required>
        </div>
        <div class="form-group">
            <label for="eventName">Evento</label>
            <input type="text" class="form-control" name="eventname" id="eventname" placeholder="Nombre del Evento" required>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Descripcion</label>
            <textarea class="form-control" name="eventdescription" id="eventdescription" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="eventdir">Ciudad del Evento</label>
            <input type="text" class="form-control" name="eventdir" id="eventdir" placeholder="Lugar del Evento" required>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="eventplace">Lugar del Evento</label>
                    <input type="text" class="form-control" name="eventplace" id="eventplace" placeholder="Dirección del Evento" required>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="eventName">Máximo de Cupos</label>
                    <input type="text" class="form-control" name="eventmax" id="eventmax" placeholder="Cantidad Máxima de participantes" required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Registro del Evento</label>
            <hr>
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="eventName">Inicio</label>
                    <div class="input-group date">
                        <input name="starlottery" id="starlottery" type="text" class="form-control" required><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="eventName">Fin</label>
                    <div class="input-group date">
                        <input name="endlottery" id="endlottery" type="text" class="form-control" required><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                    </div>
                </div>
            </div>
         </div>
         </div>
         <div class="form-group">
            <label for="exampleInputPassword1">Fecha del Evento</label>
            <hr>
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="eventName">Inicio</label>
                    <div class="input-group date">
                        <input name="starevent" id="starevent" type="text" class="form-control" required><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="eventName">Fin</label>
                    <div class="input-group date">
                        <input name="endevent" id="endevent" type="text" class="form-control" required><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="hour">Hora</label>
                    <input type="text" class="form-control" name="hour" id="hour" placeholder="10:00pm" required>
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
        language: 'es',
        todayBtn: "linked",
        format: 'dd/mm/yyyy'
    });
      </script>
@endsection