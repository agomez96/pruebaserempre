@extends('layouts.header')
@section('content')
 <!-- Content Header (Page header) -->
 <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Clientes</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                <li class="breadcrumb-item active">Clientes</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-6">  
              <div class="card card-primary card-outline">
                <div class="card-body">                
                    @include("layouts.notificacion")
                    <div class="row">
                      <div class="col-lg-6">  
                              <a data-toggle="modal" id="createClient" data-target="#modal-default" class="btn btn-success mb-2">Ingresar</a>
                      </div>
                      <div class="col-lg-6"> 
                      <form action="{{ route('clients.index') }}" method="GET" role="search">

                      <div class="input-group">                                  
                          <input type="text" class="form-control" name="term" placeholder="Buscar Ciudad" id="term">
                          <span class="input-group-btn">
                              <button class="btn btn-info" type="submit" title="Search projects">
                                  <span class="fas fa-search"></span>
                              </button>
                          </span>
                          <a href="{{ route('clients.index') }}">
                              <span class="input-group-btn">
                                  <button class="btn btn-danger" type="button" title="Refresh page">
                                      <span class="fas fa-sync-alt"></span>
                                  </button>
                              </span>
                          </a>
                          
                      </div>
                      </form>
                      </div>
                    </div>
                  <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th style="width: 10px">Cod.</th>
                            <th>Nombre</th>
                            <th>Ciudad</th>
                            <th style="width: 40px">Editar</th>
                            <th style="width: 40px">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($clients as $client)
                            <tr>
                                <td>{{$client->cod}}</td>
                                <td>{{$client->name}}</td>
                                <td>{{$client->city_d->name}}</td>
                                <td>
                                    <a class="btn btn-warning" href="#" id="editClient" data-toggle="modal" data-target='#modal-editar' data-city="{{ $client->city_d->name}}" data-id="{{ $client->cod }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                                <td>
                                    <form action="{{route('clients.destroy', [$client])}}" method="post">
                                        @method("delete")
                                        @csrf
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        </table>                  
                </div>
                <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  {!! $clients->render() !!}
                </ul>
              </div>
              </div><!-- /.card -->
            </div>            
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->
      <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Ingresar Cliente</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form method="POST" action="{{route('clients.store')}}">
            <div class="row">
                <div class="col-12">
                            @if(count($errors))
                                <div class="form-group">
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{$error}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                            @csrf
                            <input required type='hidden' name="tipo" value="1"> 
                            <div class="form-group">
                                <label class="label">Codigo</label>
                                <input required autocomplete="off" id="cod" name="cod" value="{{ old('cod') }}" class="form-control @error('cod') is-invalid @enderror"
                                    type="text">
                            </div>
                            <div class="form-group">
                                <label class="label @error('name') is-invalid @enderror">Nombre</label>
                                <input required autocomplete="off" id="name" name="name" class="form-control"
                                    type="text" placeholder="Nombre compelto"  value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label class="label @error('name') is-invalid @enderror">Ciudad</label>
                                <select required name="city" id="city" style="with:100%;" class="cities form-control select2"></select>
                            </div>                                                    
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <a class="btn btn-danger" data-dismiss="modal">Cerrar</a>
              <button type="submit" id="submit" class="btn btn-success">Guardar Cambios</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <div class="modal fade" id="modal-editar">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Modificar Ciudad</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form method="POST" action="{{route('clients.update','0')}}">
            @method("patch")
            @csrf
            <div class="row">
                <div class="col-12">
                            @if(count($errors))
                                <div class="form-group">
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{$error}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                            @csrf
                            <input required type='hidden' name="tipo" value="2">                            
                            <input required type='hidden' id="cod-e" name="cod" value="{{ old('cod') }}">
                            <div class="form-group">
                                <label class="label @error('name') is-invalid @enderror">Nombre</label>
                                <input required autocomplete="off" id="name-e" name="name" class="form-control"
                                    type="text" placeholder="Nombre completo"  value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label class="label @error('name') is-invalid @enderror">Ciudad</label>
                                <select required name="city" id="city-e" style="with:100%;" class="cities form-control select2"></select>
                            </div>                                                       
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <a class="btn btn-danger" data-dismiss="modal">Cerrar</a>
              <button type="submit" id="submit-t" class="btn btn-success">Actualizar cliente</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->      
@endsection
@section('scripts')

<script type="text/javascript">
        $(document).ready(function () {
            $('.cities').select2({
              width: '100%',
        placeholder: 'Seleccione la ciudad',
        ajax: {
            url: '/ajax-cities',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.cod
                        }
                    })
                };
            },
            cache: true
        }
        });
        })

        @if (count($errors) > 0)
            @if(old('tipo')=='1')
            $('#modal-default').modal('show');
            @endif
            @if(old('tipo')=='2')
            $('#modal-editar').modal('show');
            @endif
        @endif

        $('body').on('click', '#createClient', function (event) {
        event.preventDefault();
            $('#submit').val("Actualizar");
            $('#modal-default').modal('show');
            $('#cod').val('');
            $('#name').val('');
        });

        $('body').on('click', '#editClient', function (event) {
        event.preventDefault();
        var id = $(this).data('id');
        var city = $(this).data('city');
        $.get('clients/' + id + '/edit', function (data) {
            $('#submit').val("Actualizar");
            $('#cod-e').val(data.client.cod); 
            console.log(data)
            if ($('#city-e').find("option[value='" + data.client.city + "']").length) {
                $('#city-e').val(data.id).trigger('change');
            } else { 
                // Create a DOM Option and pre-select by default
                var newOption = new Option(city, data.client.city, true, true);
                // Append it to the select
                $('#city-e').append(newOption).trigger('change');
            }            
            $('#name-e').val(data.client.name);
            $('#modal-editar').modal('show');
        })
        });
</script>

@endsection

