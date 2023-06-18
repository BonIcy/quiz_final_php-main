// 3. Importamos la funcion Metodo HTTP - GET
import { getCampers, deleteCamper } from "../APIConnection/API.js";

//1. Funcion IIFE

(function() {
    const lista = document.querySelector('.lista')
    document.addEventListener('DOMContentLoaded',showCampers())
    lista.addEventListener('click',confirmDelete)
    async function showCampers(){
        /* console.log('desde ITFE'); */
        const campers = await getCampers();
        console.log(campers);
        const contenedor = document.querySelector('#intermedio')
        campers.forEach((camper)=>{
            const {id, nombre, imagen, promedio, especialidad, nivelIngles} = camper
            const rows = document.createElement('tr');
            rows.innerHTML = `
            <th scope="row">${id}</th>
            <td>${nombre}</td>
            <td>${promedio}</td>
            <td>${especialidad}</td>
            <td>${nivelIngles}</td>
            <td><button type="button" class="btn btn-warning detalle" data-bs-toggle="modal" data-bs-target="#exampleModal" id="${id}">Detalle</button></td>
            <td><button type="button" class="btn btn-danger delete" data-camper="${id}">Eliminar</button></td>
            `;
            contenedor.appendChild(rows);
        })
    }
    function confirmDelete(e){
        e.preventDefault();
        if(e.target.classList.contains('delete')){
            /* console.log('Se va a borrar'); */
            const camperId = parseInt(e.target.dataset.camper);
            const confirmar = confirm('¿Deseas Eliminar al Camper para que se quede en casa?')
            if(confirmar){
                deleteCamper(camperId);
            }   
        }
    }
})();

