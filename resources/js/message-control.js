import Echo from "laravel-echo"

window.Pusher = require('pusher-js')
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: false,
    wsHost: window.location.hostname,
    wsPort: 6001,
})

window.Echo.private(`user.${user.id}`).listen('.SendMessage', (response) => {
    console.log('Recebeu ', response)
    notificateMessage(response)
})

window.listenersMessage = []
window.addListenersMessage = (callback) => ( window.listenersMessage.push(callback) )

const notificateMessage = (message) => {
    const listeners = window.listenersMessage ?? [];

    console.log('tem '+ listeners.length +' ouvidores')

    for (let i=0; i < listeners.length; i++) {
        listeners[i](message.message)
    }
}
