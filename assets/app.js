/*
 * Welcome to your app's main JavaScript file!
 *
 * Appeler le fichier aasets/app.js et styles/app.css dans
 *  layout (base.html.twig).
 * {{ encore_entry_script_tags('app') }}
 * A la fin de chaque instruction js et/ou sass css il faut compiler
 *  npm run dev
 * npm run watch
 * Si ca marche WebPack encore affiche une notif en bas a droite de l'ecran
 */

// Appel du fichier css
import './styles/app.css';
//Appel de jquery
const $ = require('jquery');
// Le boostrap
import './bootstrap';

//Appel de vueJS
import Vue from 'vue';

//Afficher le nom de la photo dans input brwose
$(".custom-file-input").on("change", function (){
    let fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
})


//Test de vueJS sur un bouton
$(document).ready(function (){
    $('[data-toggle = "popover"]').popover();
});

Vue.component('button-counter', {
    data: function (){
        return{
            count: 0
        }
    },
    template: '<button v-on:click="count++">Compteur de click {{count}}</button>'
})
const app = new Vue({
    el:'#components-demo'
})
