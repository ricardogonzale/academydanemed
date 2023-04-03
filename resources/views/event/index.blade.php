@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <button type="button" class="btn btn-primary" onclick="location.href='/event/create'">Nuevo Evento</button>
    <hr>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col" style="display: none;">asd</th>
                        <th scope="col">Id Evento</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Dia</th>
                        <th scope="col">Ubicación</th>
                        <th scope="col">Cantidad Máxima</th>
                        <th scope="col">Inicio Sorteo</th>
                        <th scope="col">Fin Sorteo</th>
                        <th scope="col">Inicio Evento</th>
                        <th scope="col">Fin Evento</th>
                    </tr>
                    <tr>
                        <th scope="col" style="display: none;">asd</th>
                        <th scope="col" style="border: 1px solid #ddd;">Id Evento</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Dia</th>
                        <th scope="col">Ubicación</th>
                        <th scope="col">Cantidad Máxima</th>
                        <th scope="col">Inicio Sorteo</th>
                        <th scope="col">Fin Sorteo</th>
                        <th scope="col">Inicio Evento</th>
                        <th scope="col">Fin Evento</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($data as $item)
                <tr class="item{{$item->id}}">
                    <th style="display: none;"></th>
                    <td>{{$item->id_event}}</td>
                    <td>{{$item->event_name}}</td>
                    <td>{{$item->description}}</td>
                    <td>{{$item->day_event}}</td>
                    <td>{{$item->ubication}}</td>
                    <td>{{$item->max_register}}</td>
                    <td>{{$item->register_begin}}</td>
                    <td>{{$item->register_end}}</td>
                    <td>{{$item->event_begin}}</td>
                    <td>{{$item->event_end}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
$(document).ready( function () {
  
  var table = $('#example').DataTable({
		"order": [[ 1, "desc" ]],
        "pageLength": 100,
        "processing": true,
        "responsive": true,
        "dom": "<'row my-4'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-3 ml-1'B><'col-sm-12 col-md-6'f>>" +
        "<'row'<'col-sm-12 over'tr>>" +
        "<'row my-4'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        "columnDefs": [
            { type: 'num', targets: 1 }
        ],
        "buttons": ['copy', 'csv', {
        extend: 'copy',
        exportOptions: {
          rows: '.copy_me'
        },
      },            {
                extend: 'excelHtml5',
                header: true,
                exportOptions: {
                    columns: [ 1,2,3,4,5,6,7,8,9]
                }
            },],
		"oLanguage": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
            },
            "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
		},
        initComplete: function () {
        // hode the button
        $( this.api().button(0).node() ).css({'display': 'none'});
        }
	});
    $('#example').on('click', 'tbody input[name="copy"]', function(){
      var td = $(this).closest('tr').children('td:first');
      const el = document.createElement('textarea');     
      navigator.clipboard.writeText(td[0].lastElementChild.innerText);
      const md = document.createElement('div');
      $(md).append('<h2>Copiado al Portapapeles</h2>');
      $(md).append('<div><b>Datos: </b> <i>"' + td[0].lastElementChild.innerText + '"</i> copiados</div>')
      $(md).addClass('dt-button-info');
      document.body.appendChild(md);
      setTimeout(function(){document.body.removeChild(md)}, 2000);
  });
    $("#example thead th").each( function ( i ) {
		
		if ($(this).text() !== '') {
	        var isStatusColumn = (($(this).text() == 'Status') ? true : false);
			var select = $('<select><option value=""></option></select>')
	            .appendTo( $(this).empty() )
	            .on( 'change', function () {
	                var val = $(this).val();
					
	                table.column( i )
	                    .search( val ? '^'+$(this).val()+'$' : val, true, false )
	                    .draw();
	            } );
	 		
			// Get the Status values a specific way since the status is a anchor/image
			if (isStatusColumn) {
				var statusItems = [];
				
                /* ### IS THERE A BETTER/SIMPLER WAY TO GET A UNIQUE ARRAY OF <TD> data-filter ATTRIBUTES? ### */
				table.column( i ).nodes().to$().each( function(d, j){
					var thisStatus = $(j).attr("data-filter");
					if($.inArray(thisStatus, statusItems) === -1) statusItems.push(thisStatus);
				} );
				
				statusItems.sort();
								
				$.each( statusItems, function(i, item){
				    select.append( '<option value="'+item+'">'+item+'</option>' );
				});

			}
            // All other non-Status columns (like the example)
			else {
				table.column( i ).data().unique().sort().each( function ( d, j ) {  
					select.append( '<option value="'+d+'">'+d+'</option>' );
		        } );	
			}
	        
		}
    } );
  


  
  
} );
 </script>
 <style>
    .over {
        overflow-y: auto;
    }
 </style>
@endsection
