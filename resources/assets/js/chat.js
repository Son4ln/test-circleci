import Echo from 'laravel-echo'

if (typeof window.pusherKey !== 'undefined') {
  require('pusher-js')
  window.Echo = new Echo({
    broadcaster: 'pusher',
    key: window.pusherKey,
    cluster: window.pusherCluster,
    encrypted: true
  });
} else {
  window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: '/'
  });
}
