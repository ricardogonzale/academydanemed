<template>
    <b-container>
        <!-- Content here -->
        <b-row class="my-3 text-center">
            <b-col cols="3"></b-col>
            <b-col cols="12" md="6">
                <img src="img/Logo-Danemed-200x100px.png" alt="image" />
            </b-col>
            <b-col cols="3"></b-col>
        </b-row>
        <b-card class="mt-3 text-center" header="Academia" style="font-size: 0.9em !important;">
            <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                <b-row class="my-3">
                    <b-col cols="12" md="4" class="text-md-end">
                        <b-form-group
                            id="input-group-name"
                            label="Nombre y Apellido:"
                            label-for="input-name"
                        >
                        </b-form-group>
                    </b-col>
                    <b-col cols="12" md="6">
                        <b-form-input
                            id="input-name"
                            v-model="form.name"
                            required
                        ></b-form-input
                    ></b-col>
                </b-row>
                <b-row class="my-3">
                    <b-col cols="12" md="4" class="text-md-end">
                        <b-form-group
                            id="input-group-city"
                            label="¿Está su consultorio en CDMX?"
                            label-for="input-city"
                        >
                        </b-form-group>
                    </b-col>
                    <b-col cols="12" md="6">
                        <b-form-group v-slot="{ ariaDescribedby }">
                        <b-form-radio-group
                            v-model="selected"
                            :options="optionsmx"
                            :aria-describedby="ariaDescribedby"
                            name="plain-inline"
                            required
                            plain
                        ></b-form-radio-group>
                        </b-form-group>
                    </b-col>  
                </b-row>
                <b-row class="my-3" v-if="selected==2">
                    <b-col cols="12" md="4" class="text-md-end">
                        <b-form-group
                            id="input-group-city"
                            label="Ciudad:"
                            label-for="input-city"
                        >
                        </b-form-group>
                    </b-col>
                    <b-col cols="12" md="6">

                        <b-form-input
                            id="input-city"
                            v-model="form.city"
                            required
                        ></b-form-input
                    ></b-col>
                </b-row>
                <b-row class="my-3">
                    <b-col cols="12" md="4" class="text-md-end">
                        <b-form-group
                            id="input-group-email"
                            label="Correo Electrónico:"
                            label-for="input-email"
                        >
                        </b-form-group>
                    </b-col>
                    <b-col cols="12" md="6">
                        <b-form-input
                            id="input-email"
                            v-model="form.email"
                            type="email"
                            required
                        ></b-form-input
                    ></b-col>
                </b-row>
                <b-row class="my-3">
                    <b-col cols="12" md="4" class="text-md-end">
                        <b-form-group
                            id="input-group-what"
                            label="Whatsapp:"
                            label-for="input-what"
                        >
                        </b-form-group>
                    </b-col>
                    <b-col cols="12" md="6">
                        <b-form-input
                            id="input-what"
                            v-model="form.whatsapp"
                            type="number"
                            :formatter="formatNumber"
                            required
                        ></b-form-input
                    ></b-col>
                </b-row>
                <b-row class="my-3">
                    <b-col cols="12" md="4" class="text-md-end">
                        <b-form-group
                            id="input-group-cedula_p"
                            label="Cédula Profesional:"
                            label-for="input-cedula_p"
                        >
                        </b-form-group>
                    </b-col>
                    <b-col cols="12" md="6">
                        <b-form-input
                            id="input-1"
                            v-model="form.cedula_p"
                            type="number"
                            :formatter="formatNumberId"
                            min=99999 
                            max=999999999
                            v-on:input="repeatnumber"
                            ref="cedula_pro"
                            required
                        ></b-form-input
                    ></b-col>
                </b-row>
                <b-row class="my-3">
                    <b-col cols="12" md="4" class="text-md-end"> </b-col>
                    <b-col cols="12" md="6">
                        <b-button
                            type="submit"
                            variant="primary"
                            :disabled="cargando"
                            class="btn btn-primary btn-lg btn-block"
                            >Registrarse
                            <b-spinner small v-if="cargando"></b-spinner
                        ></b-button>
                    </b-col>
                </b-row>
            </b-form>
        </b-card>
    </b-container>
</template>

<script>
import axios from "axios";
export default {
    props: ["loteryname"],
    data() {
        return {
            form: {
                name_lottery: this.loteryname,
                name: "",
                city: "",
                email: "",
                whatsapp: null,
                cedula_p: "",
            },
            options: [
                { value: null, text: "Por favor, selecciona una opción", disabled: true },
                { text: "Si", value: "Si" },
                { text: "No", value: "No" },
            ],
            show: true,
            cargando: false,
            selected: '',
            optionsmx: [
                { text: 'Si', value: '1' },
                { text: 'No', value: '2' },
            ]
        };
    },

    methods: {
        makeToast(variant = null, title, body) {
            this.$bvToast.toast(body, {
                title: title,
                variant: variant,
                autoHideDelay: 5000,
                appendToast: true,
                solid: true,
            });
        },
        async saveData() {
            this.cargando = true;
            if (this.selected == 1){
                this.form.city = "1 - CDMX"
            }
            let formData = new FormData();
            let rawData = { info: this.form };
            rawData = JSON.stringify(rawData);
            formData.append("data", rawData);

            return await new Promise((resolve) => {
                axios.post("lottery/create", formData).then((response) => {
                    // console.log(response);
                    this.$swal(response.data);
                    if (response.status == 200){
                        this.onReset();
                    }
                    this.cargando = false;
                    resolve();
                });
            });

            // this.$swal('Hello Vue world!!!');
        },
        formatNumber(e) {
            return String(e).substring(0, 10);
        },
        formatNumberId(e) {
            return String(e).substring(0, 9);
        },
        repeatnumber(){
            var e = this.form.cedula_p;
            var keywords = ["0000", "1111", "2222", "3333", "4444", "5555", "6666", "7777", "8888", "9999"];
            var pos = -1
            var borrar = 0

            keywords.forEach(function(element) {
                pos = e.search(element.toString());
                if(pos!=-1){
                    borrar = 1
                    alert("El numero es invalido");
                }
            });
            if(borrar == 1){
                this.form.cedula_p = "";             
            }
        },
        onSubmit(event) {
            event.preventDefault();
            // alert(JSON.stringify(this.form));
            this.saveData();
            this.cargando = false;
        },
        onReset() {
            // Reset our form values
            this.selected = "";
            this.form.email = "";
            this.form.name = "";
            this.form.city = "";
            this.form.whatsapp = null;
            this.form.cedula_p = "";
            // Trick to reset/clear native browser form validation state
            this.show = false;
            this.$nextTick(() => {
                this.show = true;
            });
        },
    },
    created() {
        console.log(this.loteryname);
    },
};
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