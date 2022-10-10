// import { registerEventListeners } from "mmuo"

window.mmuo = require("mmuo");

window._ = require("lodash");

window.bootstrap = require("bootstrap");

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require("axios");

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

window.addEventListener(
    "DOMContentLoaded",
    function () {
        window.mmuo.registerEventListeners();

        function getQueryStringsFromUrl(url) {
            if (url.split("?").length > 1) {
                var query = url.split("?")[1];
                var urlSearchParams = new URLSearchParams(query);
                var params = Object.fromEntries(urlSearchParams.entries());
                return params;
            } else {
                return null;
            }
        }

        document
            .querySelector("#spin")
            .addEventListener("click", function (event) {
                window.mmuo.showSpinner();
                axios
                    .request({
                        url: `${process.env.MIX_APP_URL}/backstage/generate-matrix`,
                        headers: { "X-Requested-With": "XMLHttpRequest" },
                        params: getQueryStringsFromUrl(location.href),
                        withCredentials: true,
                    })
                    .then((response) => {
                        console.log(response.data);

                        let game = document.querySelector("#game");

                        let result = response.data;

                        var row, column;

                        game.innerHTML = "";

                        if (result.matrix) {
                            for (row = 0; row < result.matrix.length; row++) {
                                for (
                                    column = 0;
                                    column < result.matrix[row].length;
                                    column++
                                ) {
                                    var element = document.createElement("div");
                                    element.className = "py-3 rounded-full";
                                    element.innerHTML = `<img width='100' src='/storage/${result.matrix[row][column].image}'></img>`;
                                    game.appendChild(element);
                                }
                            }
                            document.querySelector(".point-div").children[1].innerHTML = result.point;
                        }
                    })
                    .catch((error) => {
                        console.log(error.response.data.message )
                        if(!error.response.data.available){
                            document.querySelector(".point-div").classList.remove('hidden');
                        }
                        window.mmuo.showCanvass(
                            "<div class='text-danger'>" +
                                error.response.data.message +
                                "</div>"
                        );
                    })
                    .then(() => {
                        window.mmuo.removeSpinner();
                    });
            });

        if (document.querySelector("#export")) {
            document
                .querySelector("#export")
                .addEventListener("click", function (event) {
                    console.log("export clicked");
                    window.mmuo.showSpinner();
                    window.location.href = `${
                        process.env.MIX_APP_URL
                    }/backstage/export-as-csv?search=${
                        document.querySelector("#search").value
                    }&criteria=${document.querySelector("#criteria").value}`;
                });
        }
    },
    false
);

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
