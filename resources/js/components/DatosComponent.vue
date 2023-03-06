<template>
    <b-container>
        <!-- Content here -->
        <b-row class="my-3 text-center">
            <b-col cols="3"></b-col>
            <b-col cols="12" md="6">
                <img src="/img/Logo-Danemed-200x100px.png" alt="image" />
            </b-col>
            <b-col cols="3"></b-col>
        </b-row>
        <b-card class="mt-3 text-center" header="Datos del Participante" style="font-size: 0.9em !important;">
            <b-form>
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
                            readonly
                        ></b-form-input
                    ></b-col>
                </b-row>
                <b-row class="my-3">
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
                            readonly
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
                            readonly
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
                            readonly
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
                            ref="cedula_pro"
                            readonly
                        ></b-form-input
                    ></b-col>
                </b-row>
                <b-row class="my-3">
                    <b-col cols="12" md="4" class="text-md-end">
                        <b-form-group
                            label="¿Aplica rellenos de Ácido Hialurónico?"
                        >
                        </b-form-group>
                    </b-col>
                    <b-col cols="12" md="6">
                        <b-form-select
                            id="input-3"
                            class="form-control"
                            v-model="form.practice"
                            :options="options"
                            readonly
                        ></b-form-select>
                    </b-col>
                </b-row>
            </b-form>
        </b-card>
    </b-container>
</template>

<script>
export default {
    props: ["id"],
    data() {
        return {
           ids: this.id,
           form: {
                name: "",
                city: "",
                email: "",
                whatsapp: null,
                cedula_p: "",
                practice: "",
            },
            options: [
                { value: null, text: "Por favor, selecciona una opción", disabled: true },
                { text: "Si", value: "Si" },
                { text: "No", value: "No" },
            ],
            show: true,
            cargando: false,
        };
    },
    methods: {
        formatNumber(e) {
            return String(e).substring(0, 10);
        },
        formatNumberId(e) {
            return String(e).substring(0, 9);
        },
        async findData(id) {
            return await new Promise((resolve) => {
                axios.get("/lottery/datos/"+id).then((response) => {
                    if (response.status == 200){
                        console.log(response);
                        this.form = response.data[0];
                    }
                });
            });
        },
    },
    mounted() {
        this.findData(this.id);
    },
};
</script>
