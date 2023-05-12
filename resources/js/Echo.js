import Vue from 'vue'
import store from './vuex/store'

const userId = window.Laravel.user

window.Echo.channel(`laravel_database_private-chat.${userId}`)
.listen('NewMessageCreated', (e) => {
    console.log(e.message);
    let conversation =  e.message
    if(!store.state.me.me.preference.me_notify) return;

    Vue.$vToastify.success(`
         Messagem: ${conversation}
    `,
    `${conversation.sender.name} te enviou uma nova mensagem`)
    store.commit('ADD_MESSAGE', conversation);
})

window.Echo.join('laravel_database_chatroom')
.here(users=>{
    console.log('Usuarios Online');
    console.log(users);
    store.commit('ADD_ONLINE_USERS', users);
})
.joining(user=>{
    console.log('Entrou:');
    console.log(user);
    store.commit('ADD_ONLINE_USER', user);
})
.leaving(user=>{
    console.log('Saiu:');
    console.log(user);
    store.commit('REMOVE_ONLINE_USER', user);
})
