<template>
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="#">Inicio</a></li>
                        <li class="active">Editar usuario</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <router-link :to='{name:"mostrarUsuarios"}' class="btn btn-secondary"><i
                        class="fa fa-angle-left"></i> Atrás
                    </router-link>
                </div>
            </header>
            <form @submit.prevent="actualizar">
                <div class="card-block">
                    <div class="form-group">
                        <label class="form-label" for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" placeholder="Nombre" v-model="usuario.name">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="email">Correo electrónico</label>
                        <input type="email" class="form-control" id="email" placeholder="Correo electrónico"
                               v-model="usuario.email">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" placeholder="Contraseña"
                               v-model="usuario.password">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">Repetir contraseña</label>
                        <input type="password" class="form-control" id="password_confirmation"
                               placeholder="Confirmar contraseña" v-model="usuario.password_confirmation">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                </div>
            </form>
        </section>
    </div><!--.container-fluid-->

</template>
<script>
export default {
    name: "editar-usuario",
    data() {
        return {
            usuario: {
                name: "",
                email: "",
                password: "",
                password_confirmation: "",
            }
        }
    },
    mounted() {
        this.mostrarUsuario()
    },
    methods: {
        async mostrarUsuario() {
            this.axios.get(`/usuarios/${this.$route.params.id}`)
                .then(response => {
                    const {name, email, password} = response.data
                    this.usuario.name = name,
                        this.usuario.email = email,
                        this.usuario.password = password
                })
                .catch(error => {
                    console.log(error)
                })
        },
        async actualizar() {
            this.axios.put(`/usuarios/${this.$route.params.id}`, this.usuario)
                .then(response => {
                    this.$router.push({name: "mostrarUsuarios"})
                })
                .catch(error => {
                    console.log(error);
                })
        }
    }
}
</script>

