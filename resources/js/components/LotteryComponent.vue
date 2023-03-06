<template>
    <b-container>
        <!-- Content here -->
        <b-row class="my-3 text-center">
            <b-col cols="3"></b-col>
            <b-col cols="6">
                <img src="img/Logo-Danemed-200x100px.png" alt="image" />
            </b-col>    
            <b-col cols="3"></b-col>
        </b-row>
        <b-card class="mt-3 text-center" header="Academia Danemed">
            <b-form>
                <b-row class="my-3" v-for="type in form" v-bind:key="type.id">
                    <b-col cols="3" class="text-end">
                    </b-col>
                    <b-col cols="6">
                        <b-button  @click="openLottery(type.id_event)" variant="primary" :disabled="cargando" class="btn btn-primary btn-lg btn-block">{{ type.event_name }} <b-spinner small v-if="cargando"></b-spinner></b-button>
                    </b-col>
                </b-row>
            </b-form>
        </b-card>
    </b-container>
</template>

<script>
export default {
    data() {
        return {
            show: true,
            cargando: false,
            form: {}
        };
    },
    methods: {
        openLottery(url){
            // this.cargando = true,
            // this.$swal('Hello Vue world!!!');
            window.location.href = '/'+url;
        },
        async findEvents() {
            return await new Promise((resolve) => {
                axios.get("/event/list").then((response) => {
                    if (response.status == 200){
                        console.log(response);
                        this.form = response.data;
                    }
                });
            });
        },
    },
    mounted() {
        this.findEvents();
    },
};
</script>
