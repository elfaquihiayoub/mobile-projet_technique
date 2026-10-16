const API_URL="http://localhost:8000/backend/api/api.php";
const tbody=document.getElementById("table-categories-body");
const form=document.getElementById("form-categorie");
const namefield=document.getElementById("cat-nom");
const descriptionfield=document.getElementById("cat-desc");

const btn_cancel_form=document.getElementById("btn-cancel-form")
const bnt_show_form=document.getElementById("btn-show-form")
const section_form=document.getElementById("section-form")


function showThematiques(){
    fetch(API_URL)
    .then(Response=>Response.json())
    .then(thematiques=>{
        tbody.innerHTML=""
        thematiques.forEach(thematique => {
            tbody.innerHTML+=`
                  <tr>
                         <td class="p-4 text-sm font-semibold text-gray-500 ">${thematique.id}</td>
                        <td class="p-4 text-sm font-semibold text-gray-500 ">${thematique.name}</td>
                         <td class="p-4 text-sm font-semibold text-gray-500 ">${thematique.description}</td>
                                
                 </tr>
            `
        });
    })
}

form.addEventListener("submit",function(event){
    event.preventDefault()
    const data={
        "name": namefield.value,
        "description": descriptionfield.value
    }

    fetch(API_URL,{
        method: "POST",
        headers:{
            "Content-Type": "application/json"
        },
        body:JSON.stringify(data) 
    })
    .then(Response=>Response.json())
    .then(()=>{
        form.reset()
        showThematiques()
    })
})












bnt_show_form.addEventListener("click",function(){
    section_form.classList.remove("hidden")
})


document.addEventListener("DOMContentLoaded",showThematiques)
// -----------------------------------------------------------
btn_cancel_form.addEventListener("click",function(){
    form.reset();
})