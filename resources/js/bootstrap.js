// import { registerEventListeners } from "mmuo"

window.mmuo = require("mmuo");

window._ = require('lodash');

window.bootstrap = require('bootstrap');


/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.addEventListener("DOMContentLoaded", function() {
    window.mmuo.registerEventListeners()

    

    document.querySelector("#spin").addEventListener('click', function(event){
        window.mmuo.showSpinner()
        axios.request({
            url: `${process.env.MIX_APP_URL}/backstage/generate-matrix`,
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            withCredentials: true
          }).then((response) => {
            console.log(response.data)

            let game = document.querySelector("#game")

            let result = response.data

            var row, column

            game.innerHTML = "";

            for(row=0;row < result.length;row++){
                for(column=0;column < result[row].length;column++){
                    var element = document.createElement("span");
                    element.className = "bg-blue-500 hover:bg-green-700 text-white font-bold py-3 px-5 rounded-full";
                    element.innerHTML = result[row][column];
                    game.appendChild(element);
                }
            }
        }).catch((error) => {
            window.mmuo.showCanvass("<div class='text-danger'>"+error.response.data.message +"</div>")
        }).then(() => {
            window.mmuo.removeSpinner()
        })
        console.log("I was clicked")
    });

}, false);

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
