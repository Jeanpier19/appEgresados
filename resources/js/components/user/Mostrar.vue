<template>
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="#">Inicio</a></li>
                        <li class="active">Lista de usuarios</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <router-link :to='{name:"crearUsuario"}' class="btn btn-inline btn-success"><i class="fa fa-plus"></i> Nuevo
                    </router-link>
                </div>
            </header>
            <div class="card-block">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="usuario in usuarios" :key="usuario.id">
                                <td>{{ usuario.id }}</td>
                                <td>{{ usuario.name }}</td>
                                <td>{{ usuario.email }}</td>
                                <td>
                                    <router-link :to='{name:"editarUsuario",params:{id:usuario.id}}'
                                                 class="btn btn-info"><i class="fa fa-edit"></i></router-link>
                                    <a type="button" @click="borrarUsuario(usuario.id)" class="btn btn-danger"><i
                                        class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div><!--.container-fluid-->
</template>
<script>
export default {
    name: "usuarios",
    data() {
        return {
            usuarios: []
        }
    },
    mounted() {
        this.mostrarUsuarios();
    },
    methods: {
        async mostrarUsuarios() {
            await this.axios.get('/usuarios')
                .then(response => {
                    this.usuarios = response.data
                })
                .catch(error => {
                    console.log(error)
                    this.usuarios = []
                })
        },
        borrarUsuario(id){
            if(confirm("¿Confirma eliminar el registro?")){
                this.axios.delete(`/usuarios/${id}`)
                .then(response => {
                    this.mostrarUsuarios()
                })
                .catch(error => {
                    console.log(error)
                    this.usuarios = []
                })
            }
        }
    }
}
</script>
