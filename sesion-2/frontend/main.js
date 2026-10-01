const API_URL="../backend/api.php";
const tableBody=document.getElementById("table-thematiques-body") ;

const form=document.getElementById("form-thematique");
const nom_thematique=document.getElementById("nom_thematique");
const description_thematique=document.getElementById("description_thematique");

function showThematique(){
    fetch(API_URL)
    .then(Response=>Response.json())
    .then(thematiques=>{
        
        tableBody.innerHTML='';
        thematiques.forEach(thematique => {
            tableBody.innerHTML+=`
            <tr>
            <td class="px-6 py-4 text-gray-500">${thematique.id_thematique}</td>
            <td >${thematique.nom_thematique}</td>
                <td>
                    <button class="text-blue-600 hover:underline text-xs">Modifier</button>
                    <button class="text-red-500 hover:underline text-xs">Supprimer</button>
                <td/>
            </tr>
            `
            
        });
    });

};
form.addEventListener("submit",function(event){
    event.preventDefault();
    const data ={
        nom_thematique : nom_thematique.value,
        description_thematique : description_thematique.value,
};
fetch(API_URL,{
    method: "POST",
    headers:{
        "content-type":"application/json"
    },
    body: JSON.stringify(data)
})
.then(Response=>Response.json())
.then(()=>{
    form.reset();
    showThematique()
})

})
document.addEventListener("DOMContentLoaded", showThematique());