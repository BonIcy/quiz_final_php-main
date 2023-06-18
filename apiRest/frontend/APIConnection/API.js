const url = "http://localhost/apiRest/backend/controllers/campers.php?op=";

export const getCampers = async ()=>{
    try {
        const result = await fetch(`${url}GetAll`);
        const campers = await result.json()
        return campers;

    } catch (error) {
        console.log(error);
    }
}

// INSERTAR nuevo camper en REST API (Metodo HTTP: POST)

export const newCamper = async camper=>{
    console.log(camper);
    try {
        await fetch(url,{
            method: 'POST',
            body: JSON.stringify(camper),
            headers: {
                'Content-Type':'application/json'
            }
        });
        window.location.href='index.html'
    } catch (error) {
        console.log(error);
    }

}

// Eliminar campers - Metodo HTTP (DELETE)

export const deleteCamper = async id=>{
    try {
        await fetch(`${url}/${id}`,{
            method: 'DELETE'
        })
    } catch (error) {
        console.log(error);
    }
}