@extends('layouts.app')

@section('content')
<h1 class="">
    Accesos al gimnasio
</h1>
<div class="row">
    <div class="col">
        <label for="min">Fecha inicio</label>
        <input type="text" id="min">
    </div>
    <div class="col">
        <label for="max">Fecha fin</label>
        <input type="text" id="max">
    </div>
</div>
<hr>
<div class="row">
    <button class="btn btn-dark ml-auto" onclick="updateTable()">Refrescar</button>
</div>
<hr>
<div class="row">
    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="usersTable">
            <thead class="thead-dark">
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<script>
    var table;
    $(function(){
       /*var users = [
          {
            "id": 1,
            "fecha_hora_ingreso": "2018-08-13T21:04:35.31",
            "usuario": "usuario_test"
          },
          {
            "id": 4,
            "fecha_hora_ingreso": "2018-08-13T21:13:40.357",
            "usuario": "test2"
          },
          {
            "id": 5,
            "fecha_hora_ingreso": "2018-08-14T03:16:01.127",
            "usuario": "test3"
          }
        ];*/

      $('#min').datepicker({
        value: moment().startOf('month').format('YYYY-MM-DD'),
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        change: function(e){
          table.draw();
        },
      });
      $('#max').datepicker({
        value: moment().endOf('month').format('YYYY-MM-DD'),
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        change: function(e){
          table.draw();
        },
      });

      $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
          var min = moment($('#min').datepicker().value());
          var max = moment($('#max').datepicker().value());
          var startDate = moment(data[2]);
          if (min == null && max == null) { return true; }
          if (min == null && startDate <= max) { return true;}
          if(max == null && startDate >= min) {return true;}
          if (startDate <= max && startDate >= min) { return true; }
          return false;
        }
      );

      getData();
    });

    function getData(){
      var fecha = moment("2018-08-13T21:04:35.31");
      var users = [
        {
          "id": 1,
          "fecha": fecha.format('YYYY-MM-DD'),
          "hora": fecha.format('hh:mm a'),
          "nombre": "usuario_test"
        },
        {
          "id": 4,
          "fecha": fecha.format('YYYY-MM-DD'),
          "hora": fecha.format('hh:mm a'),
          "nombre": "test2"
        },
        {
          "id": 5,
          "fecha": fecha.format('YYYY-MM-DD'),
          "hora": fecha.format('hh:mm a'),
          "nombre": "test3"
        }
      ];

      table = $("#usersTable").DataTable({
                /*ajax: {
                  type: "GET",
                  url: 'http://serviciosrestumg.azurewebsites.net/api/vwControlUsuarios',
                  dataSrc: function(json){
                    return $.map(json,function(i){
                      var fecha = moment(i.fecha_hora_ingreso);
                      return [{
                        "id": i.id,
                        "nombre": i.nombre,
                        "fecha": fecha.format('YYYY-MM-DD'),
                        "hora": fecha.format('hh:mm a'),
                      }]
                    })
                  }
                },*/
                data: users,
                columns: [
                  {data: 'id'},
                  {data: 'nombre'},
                  {data: 'fecha'},
                  {data: 'hora'},
                ],
                order: [
                  [2, 'desc'],
                  [3, 'desc'],
                ],
                dom: 'Bf',
                buttons: [
                  'excel'
                ],
              });
      /*table.buttons().container()
        .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );*/
    }

    function updateTable(){
      table.ajax.reload();
    }
</script>
@endsection
