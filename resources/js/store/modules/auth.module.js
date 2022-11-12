import axios from "axios";
import router from '@/router/index.js';

const TOKEN_KEY = 'x_xsrf_token';

export default {
    namespaced: true,
    state() {
        return {
            token: localStorage.getItem(TOKEN_KEY),
            nickname: '',
            id: '',
            name: '',
            surname: '',
        }
    },
    mutations: {
        setToken(state, token) {
            state.token = token;
            localStorage.setItem(TOKEN_KEY, token);
        },
        async logout(state) {
            state.token = null;
            localStorage.removeItem(TOKEN_KEY);
            await axios.get('/sanctum/csrf-cookie');
        },

    },
    actions: {
        async login({ commit, dispatch }, payload) {

            try {
                await axios.get('/sanctum/csrf-cookie');
                const data = await axios.post('/login', {
                    email: payload.email,
                    password: payload.password,
                });
                console.log('login data',data);
                localStorage.setItem('x_xsrf_token', data.config.headers['X-XSRF-TOKEN']);
                commit('setToken', data.config.headers['X-XSRF-TOKEN']);
                router.push({name: 'Dashboard',});
            } catch(e) {
                dispatch('notification/displayMessage', {
                    value: 'E-mail или пароль не верны',
                    type: 'error',
                }, {root:true});
            }


        },
        async logout({commit}) {
            // try{
                await axios.post('/logout');
                localStorage.removeItem('x_xsrf_token');
                router.push('/');
                commit('logout');
            // } catch (e) {
            //     console.log(e.message);
            // }

        }
    },
    getters: {
        token(state) {
            return state.token;
        },
        isAuthenticated(_, getters) {
            return !!getters.token;
        }
    }
}
