@extends('layouts.header')
@section('content')
 <!-- Content Header (Page header) -->
 <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Ciudades</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                <li class="breadcrumb-item active">Ciudades</li>
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
                    <a data-toggle="modal" id="createCity" data-target="#modal-default" class="btn btn-success mb-2">Ingresar</a>
                    @include("layouts.notificacion")
                  <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th style="width: 10px">Cod.</th>
                            <th>Nombre</th>
                            <th style="width: 40px">Editar</th>
                            <th style="width: 40px">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($cities as $city)
                            <tr>
                                <td>{{$city->cod}}</td>
                                <td>{{$city->name}}</td>
                                <td>
                                    <a class="btn btn-warning" href="#" id="editCity" data-toggle="modal" data-target='#modal-editar' data-id="{{ $city->cod }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                                <td>
                                    <form action="{{route('cities.destroy', [$city])}}" method="post">
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
                  {!! $cities->render() !!}
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
              <h4 class="modal-title">Ingresar Ciudad</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form method="POST" action="{{route('cities.store')}}">
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
                                    type="text" placeholder="Cod. Ciudad">
                            </div>
                            <div class="form-group">
                                <label class="label @error('name') is-invalid @enderror">Nombre</label>
                                <input required autocomplete="off" id="name" name="name" class="form-control"
                                    type="text" placeholder="Nombre"  value="{{ old('name') }}">
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
            <form method="POST" action="{{route('cities.update','0')}}">
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
                                    type="text" placeholder="Nombre"  value="{{ old('name') }}">
                            </div>                                                    
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <a class="btn btn-danger" data-dismiss="modal">Cerrar</a>
              <button type="submit" id="submit" class="btn btn-success">Actualizar Ciudad</button>
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
        @if (count($errors) > 0)
            @if(old('tipo')=='1')
            $('#modal-default').modal('show');
            @endif
            @if(old('tipo')=='2')
            $('#modal-editar').modal('show');
            @endif
        @endif


        $('body').on('click', '#createCity', function (event) {
        event.preventDefault();
            $('#submit').val("Actualizar");
            $('#modal-default').modal('show');
            $('#cod').val('');
            $('#name').val('');
        });

        $('body').on('click', '#editCity', function (event) {
        event.preventDefault();
        var id = $(this).data('id');
        //console.log(id)
        $.get('cities/' + id + '/edit', function (data) {
            //console.log(data);
            $('#submit').val("Actualizar");
            $('#modal-editar').modal('show');
            $('#cod-e').val(data.city.cod);
            $('#name-e').val(data.city.name);
        })
        });
</script>

@endsection

