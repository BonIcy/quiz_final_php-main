import { newCamper } from "../apiConnection/API.js";

const formulario = document.querySelector('#formulario')
formulario.addEventListener('submit',validateCamper);

function validateCamper(e){
    e.preventDefault();
    const nombre = document.querySelector('#nombre').value;
    const promedio = document.querySelector('#promedio').value;
    const edad = document.querySelector('#edad').value;
    const nivelIngles = document.querySelector('#nivelIngles').value;
    const especialidad = document.querySelector('#especialidad').value;
    const nivelCampus = document.querySelector('#nivelCampus').value;
    const expertoTecnologia = document.querySelector('#expertoTecnologia').value;

    // Literal Object Enhacement
    const camper ={
        imagen: 'campus-removebg-preview.png',
        nombre,
        promedio,
        edad,
        nivelIngles,
        especialidad,
        nivelCampus,
        expertoTecnologia
    }
    /* console.log(!Object.values(camper).every(element => element !== '')); */
    if(validate(camper)){
        alert('Todos los Campos son Obligatorios');
        return;
    } else {
        newCamper(camper)
    }
}

function validate(camper){
    return !Object.values(camper).every(element => element !== '')
}
