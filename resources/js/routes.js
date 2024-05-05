const Home = ()=> import('./components/Home.vue');

const Mostrar = ()=> import('./components/user/Mostrar.vue');
const Crear = ()=> import('./components/user/Crear.vue');
const Editar = ()=> import('./components/user/Editar.vue');


export const routes = [
    {
        name: 'home',
        path: '/home',
        component: Home
    },
    {
        name: 'mostrarUsuarios',
        path: '/mostrar',
        component: Mostrar
    },
    {
        name: 'crearUsuario',
        path: '/crear',
        component: Crear
    },
    {
        name: 'editarUsuario',
        path: '/editar/:id',
        component: Editar
    }
]
