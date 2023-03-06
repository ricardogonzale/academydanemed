<template>
  <b-table hover outlined responsive light :items="users" :fields="fields" id="example">
    <template #cell(actions)="row">
      <b-icon-clipboard @click="copydata(row.item)" style="cursor: pointer;"></b-icon-clipboard>
    </template>
  </b-table>   
</template>
 
<script>
//Bootstrap and jQuery libraries
import 'bootstrap/dist/css/bootstrap.min.css'; //for table good looks
import 'jquery/dist/jquery.min.js';
//Datatable Modules
import "datatables.net-dt/js/dataTables.dataTables"
import "datatables.net-dt/css/jquery.dataTables.min.css"
import "datatables.net-buttons/js/dataTables.buttons.js"
import "datatables.net-buttons/js/buttons.colVis.js"
import "datatables.net-buttons/js/buttons.flash.js"
import "datatables.net-buttons/js/buttons.html5.js"
import "datatables.net-buttons/js/buttons.print.js"
import $ from 'jquery'; 
import axios from 'axios'; //for api calling
export default {
  
  mounted(){
    //Web api calling for dynamic data and you can also use into your demo project
    axios
    .get("lottery/competitor/allData")
    .then((res)=>
    {
      this.users = res.data;
      setTimeout(function(){
      $('#example').DataTable(
          {
              pagingType: 'full_numbers',
              pageLength: 100,
              processing: true,
              responsive: true,
              dom: "<'row my-4'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-3 ml-1'B><'col-sm-12 col-md-6'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row my-4'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                  buttons: ['copy', 'csv', 'print'
                  ]
          }
      );
      },
        1000
        );
    })
  },
  data: function() {
        return {
            fields: [
              { key: 'actions', label: '', class: 'text-center' },
              {
                key: 'name_lottery',
                label: 'Sorteo',
                sortable: false
              },
              {
                key: 'name',
                label: 'Nombre',
                sortable: false
              },
              {
                key: 'city',
                label: 'Ciudad',
                sortable: false
              },
              {
                key: 'email',
                label: 'Sorteo',
                sortable: false
              },
              {
                key: 'whatsapp',
                sortable: false
              },
              {
                key: 'cedula_p',
                label: 'Cedula Profesional',
                sortable: false
              },
              {
                key: 'practice',
                label: '¿Aplica Acidos?',
                class: 'text-center',
                sortable: false
              },
              {
                key: 'agent',
                label: 'Agente',
                class: 'text-center',
                sortable: false
              },
            ],          
            users:[]
        }
    },
    methods: 
    {
      copydata(items){
        var data = "Sorteo: "+items.name_lottery+"\r"+"Nombre: "+items.name+"\r"+"Ciudad: "+items.city+"\r"+"Correo electrónico: "+items.email+"\r"+"Whatsapp: "+items.whatsapp+"\r"+"Cédula Profesional: "+items.cedula_p+"\r"+"Aplica Acidos: "+items.practice+"Agente: "+items.agent;
        navigator.clipboard.writeText(data);
        this.$swal({
            toast: true,
            timer: 1000,
            timerProgressBar: true,
            showConfirmButton: false,
            title: "Copiado",
            icon: "success"
        });
      }
    },
}
</script>
<style>
  .swal2-title {
    font-size: 1.2em !important;
  }
  .swal2-popup {
    width: 26em !important;
    padding: 0 0 .5em !important;
  }
</style>