import swal from 'sweetalert'
window.axios = require('axios')
import flatpickr from "flatpickr"

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

window.addEventListener("DOMContentLoaded", function() {
    document.querySelector("#export").addEventListener('click', function(event){
        console.log("export clicked")
        //window.mmuo.showSpinner()
        window.location.href = `${process.env.MIX_APP_URL}/backstage/export-as-csv?search=${document.querySelector("#search").value}&criteria=${document.querySelector("#criteria").value}`;
    });
})