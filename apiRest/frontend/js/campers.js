const intermedio = document.querySelector('#intermedio')

const contenedor = document.querySelector('#container')

document.addEventListener('DOMContentLoaded',()=>{
    listaIntermedio();
    datosModal();
})

async function listaIntermedio(){
    const url = "http://localhost/apiRest/backend/controllers/campers.php?op="
    try{
        const response = await fetch(`${url}GetAll`)
        const result = await response.json()
        console.log(result.campers);
        imprimirIntermedios(result.campers)
    } catch (error) {
        console.log(error);
    }
}

function imprimirIntermedios(campers){
    html = ''
    campers.forEach(camper => {
        const {imagen,nombre,edad,promedio,nivelCampus,nivelIngles,especialidad,expertoTecnologia,detalle,celular,direccion,id} = camper
        html += `
        <tr>
            <td>${id}</td>
            <td>${nombre}</td>
            <td>${promedio}</td>
            <td>${especialidad}</td>
            <td>${nivelIngles}</td>
            <td><button class="btn btn-primary detalle" data-bs-toggle="modal" data-bs-target="#exampleModal" id="${id}">VER</button></td>
        </tr>
        `;
        intermedio.innerHTML = `${html}`
    });
}
