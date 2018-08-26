@extends('layouts.app')

@section('content')
    <h1 class="">
        Usuarios del gimnasio
    </h1>
    <div class="row">
        <div class="table-responsive">
            <table id="tblUsuarios" class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <script>
        $(function(){
          $("#tblUsuarios").DataTable({
            ajax: {
              type: "GET",
              url: 'http://serviciosrestumg.azurewebsites.net/api/usuarios',
              dataSrc: function(json){
                return json
              },
            },
            columns: [
              {data: 'id_usuario'},
              {data: 'nombre'},
            ],
          });
        })
    </script>
@endsection