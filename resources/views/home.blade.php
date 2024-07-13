@extends('layouts.app')

@section('css')
    <style>
        .whatsapp-bar {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            background-color: #25D366;
            /* Color de fondo de WhatsApp */
            border-radius: 50px;
            padding: 10px 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
        }

        .whatsapp-bar:hover {
            background-color: #128C7E;
        }

        .whatsapp-bar a:hover,
        .whatsapp-bar a i:hover {
            color: #fff;
        }

        .whatsapp-bar a:focus,
        .whatsapp-bar a i:focus {
            color: #000;
        }

        .whatsapp-link {
            display: flex;
            align-items: center;
            font-size: 18px;
            color: #fff;
            /* Color del texto */
            text-decoration: none;
        }

        .whatsapp-link i {
            font-size: 24px;
            margin-right: 10px;
        }

        .whatsapp-link:hover {
            /* Color al pasar el ratón */
            border-radius: 50px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-no-border alert-close alert-dismissible fade in">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <p>{{ $message }}</p>
            </div>
        @endif
        @switch (Auth::user()->getRoleNames()[0])
            @case('Administrador')
                <div class="row">
                    <div class="col-xs-6">
                        <div class="col-sm-6">
                            <article class="statistic-box red">
                                <div>
                                    <div class="number">{{ $cantidad_egresados }}</div>
                                    <div class="caption">
                                        <div>Egresados Pre Grado</div>
                                    </div>
                                </div>
                            </article>
                        </div><!--.col-->
                        <div class="col-sm-6">
                            <article class="statistic-box purple">
                                <div>
                                    <div class="number">{{ $cantidad_graduados }}</div>
                                    <div class="caption">
                                        <div>Bachiller</div>
                                    </div>
                                </div>
                            </article>
                        </div><!--.col-->
                        <div class="col-sm-6">
                            <article class="statistic-box yellow">
                                <div>
                                    <div class="number">{{ $cantidad_titulados }}</div>
                                    <div class="caption">
                                        <div>Titulados</div>
                                    </div>
                                </div>
                            </article>
                        </div><!--.col-->
                        <div class="col-sm-6">
                            <article class="statistic-box blue">
                                <div>
                                    <div class="number">{{ $cantidad_postgrado }}</div>
                                    <div class="caption">
                                        <div>Egresados Postgrado</div>
                                    </div>
                                </div>
                            </article>
                        </div><!--.col-->
                        <div class="col-sm-6">
                            <article class="statistic-box green">
                                <div>
                                    <div class="number">{{ $cantidad_maestria }}</div>
                                    <div class="caption">
                                        <div>Maestría</div>
                                    </div>
                                </div>
                            </article>
                        </div><!--.col-->
                        <div class="col-sm-6">
                            <article class="statistic-box teal">
                                <div>
                                    <div class="number">{{ $cantidad_doctorados }}</div>
                                    <div class="caption">
                                        <div>Doctorado</div>
                                    </div>
                                </div>
                            </article>
                        </div><!--.col-->
                        <div class="col-sm-6">
                            <article class="statistic-box orange">
                                <div>
                                    <div class="number">{{ $cantidad_ofertas_laborales }}</div>
                                    <div class="caption">
                                        <div>Ofertas laborales</div>
                                    </div>
                                </div>
                            </article>
                        </div><!--.col-->
                    </div>
                    <div class="col-xs-6">
                        <section class="widget widget-pie-chart">
                            <div class="no-padding">
                                <div class="tbl tbl-grid text-center">
                                    <div class="tbl-row">
                                        <div class="tbl-cell tbl-cell-50">
                                            <div class="display-inline">
                                                <div class="chart-legend">
                                                    <div class="circle green"></div>
                                                    <div class="percent">{{ $convenios_vigentes }}</div>
                                                    <div class="caption">Vigentes</div>
                                                </div>
                                                <div class="chart-legend">
                                                    <div class="circle orange"></div>
                                                    <div class="percent">{{ $convenios_por_finalizar }}</div>
                                                    <div class="caption">Por finalizar</div>
                                                </div>
                                                <div class="chart-legend">
                                                    <div class="circle red"></div>
                                                    <div class="percent">{{ $convenios_no_vigentes }}</div>
                                                    <div class="caption">No vigentes</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tbl-cell tbl-cell-50">
                                            <div class="ggl-pie-chart-container">
                                                <div id="donutchart" class="ggl-pie-chart"></div>
                                                <div class="ggl-pie-chart-title">
                                                    <div class="caption">Total</div>
                                                    <div class="number">{{ $convenios }}</div>
                                                    <div class="caption"><a href="{{ route('convenios.index') }}">Convenios</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section><!--.widget-pie-chart-->
                    </div>
                </div>
                <div class="row">
                </div>
            @break

            @case('Egresado')
                <div class="col-xs-6">
                    <div class="col-sm-6">
                        <article class="statistic-box green">
                            <div>
                                <div class="number">{{ $cantidad_ofertas_laborales }}</div>
                                <div class="caption">
                                    <div>Ofertas laborales</div>
                                </div>
                            </div>
                        </article>
                    </div><!--.col-->
                    @if ($escuela_nombre)
                        @foreach ($grupos_whatsapp as $grupo => $enlace)
                            @if ($grupo === $escuela_nombre)
                                <div class="whatsapp-bar">
                                    <a href="{{ $enlace }}" target="_blank" class="whatsapp-link">
                                        <i class="fab fa-whatsapp"></i> WhatsApp
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <p>No se encontró la escuela del usuario.</p>
                    @endif
                </div>
            @break
        @endswitch
    </div>
@endsection
