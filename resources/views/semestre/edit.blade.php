@extends('layouts.app')
@section('css')
<style>
    .error {
  color: #a94442;
  background-color: #f2dede;
  border-color: #ebccd1;
  padding:1px 20px 1px 20px;
}
label.error {
  color: #a94442;
  background-color: #f2dede;
  border-color: #ebccd1;
  padding:1px 20px 1px 20px;
}

    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li><a href="{{route('semestre.index')}}">Semestre</a></li>
                        <li class="active">Editar</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <a href="{{route('semestre.index')}}" class="btn btn-inline btn-secondary btn-rounded btn-sm"><i
                            class="fa fa-angle-left"></i> Atrás</a>
                </div>
            </header>
            {!! Form::model($semestre, ['id'=>'form-semestre','method' => 'PATCH','route' => ['semestre.update', $semestre->id]]) !!}
            <div class="card-block">
                @if (count($errors) > 0)
                    <div class="alert alert-danger alert-no-border alert-close alert-dismissible fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Whoops!</strong> Hubo algunos problemas con su entrada.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Año Académico</strong><br>
                            {!! Form::select('idanio', $anios, array('class' => 'form-control'),['class' => 'custom-select']) !!}
                        </div>
                        <div class="form-group">
                            <strong>Descripcion del Semestre:</strong>
                            {!! Form::text('descripcion', null, array('placeholder' => 'Descripcion del Semestre','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group">
                            <strong>Fecha Inicio del Semestre:</strong>
                            {!! Form::date('fecha_inicio', null, array('placeholder' => 'Fecha de inicio','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group">
                            <strong>Fecha Fin del Semestre:</strong>
                            {!! Form::date('fecha_fin', null, array('placeholder' => 'Fecha de cierre','class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Guardar</button>
            </div>
            {!! Form::close() !!}
        </section>
    </div><!--.container-fluid-->
@endsection
@section('js')
       <script type="text/javascript">
       $(document).ready(function(){
           $('#form-semestre').validate({
               lang: 'es',
               rules:{
                   idanio {
                       required: true
                   },
                   descripcion: {
                       required: true
                   },
                   fecha_inicio: {
                       required: true
                   }
                   fecha_fin: {
                       required: true
                   }
               },
               messages: {
                   idanio:"Seleccione una opción.",
                   descripcion:"Este campo es requerido.",
                   fecha_inicio:"Seleccione una fecha.",
                   fecha_fin:"Seleccione una fecha.",
               }
           });
       });
       </script>
@endsection
