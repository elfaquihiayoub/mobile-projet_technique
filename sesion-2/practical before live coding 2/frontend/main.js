

    const API_URL="/../backend/api/api.php";
    const tableBody=document.getElementById("table-categories-body");
    const formField=document.getElementById("section-form");
    const form=document.getElementById("form-categorie");
    const namefield=document.getElementById("cat-nom");
    const descriptionfield=document.getElementById("cat-desc");
    const showForm=document.getElementById("btn-show-form");
    const annulerForm=document.getElementById("btn-cancel-form");

    function showThematique(){
        fetch(API_URL)
        .then(Response=>Response.json())
        .then(thematiques=>{
            tableBody.innerHTML="";
            thematiques.forEach(thematique => {
                
                tableBody.innerHTML+=`
                <tr>
                <td class="p-4 text-sm font-semibold text-gray-500" >${thematique.id}</td>
                <td class="p-4 text-sm font-semibold text-gray-500 ">${thematique.name}</td>
                <td class="p-4 text-sm font-semibold text-gray-500 ">${thematique.description}</td>
                </tr>`
            });

        })
    }
    form.addEventListener("submit",function(event){
        event.preventDefault()
        const data ={
            name:namefield.value,
            description:descriptionfield.value
    }
        fetch(API_URL,{
            method:"POST",
            headers:{
                "Content-Type": "application/json"
            },
            body:JSON.stringify(data)
        })
        .then(Response=>Response.json())
        .then(()=>{
            form.reset();
            showThematique( )
        }
        )
        

    })



     

     showForm.addEventListener("click",function(){
    formField.classList.remove("hidden");
})
annulerForm.addEventListener("click", function(){
    form.reset();
})
document.addEventListener("DOMContentLoaded",showThematique())


