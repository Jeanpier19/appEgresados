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
                        <li><a href="{{route('doctorado.index')}}">Doctorado</a></li>
                        <li class="active">Editar</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <a href="{{route('doctorado.index')}}" class="btn btn-inline btn-secondary btn-rounded btn-sm"><i
                            class="fa fa-angle-left"></i> Atrás</a>
                </div>
            </header>
            {!! Form::model($doctorado, ['method' => 'PATCH','route' => ['doctorado.update', $doctorado->id]]) !!}
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
                            <strong>Nombre:</strong>
                            {!! Form::text('nombre', null, array('placeholder' => 'Nombre del Doctorado','class' => 'form-control')) !!}
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
           $('#form-doctorado').validate({
               lang: 'es',
               rules:{
                   nombre: {
                       required: true
                   }
               },
               messages: {
                   nombre: "Este campo es requerido"
               }
           });
       });
       </script>
@endsection
