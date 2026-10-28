const API_URL="http://localhost:8000/backend/api/controllers/controllerThematique.php"
const tbody=document.getElementById("table-categories-body")
const form=document.getElementById("form-categorie")
const nameF=document.getElementById("cat-nom")
const descriptionF=document.getElementById("cat-desc")
const showForm=document.getElementById("btn-show-form");
const annulerForm=document.getElementById("btn-cancel-form");
const formField=document.getElementById("section-form");
const spinner=document.getElementById("spinner")
const btnText = document.getElementById("btn-text");
const btnSubmit = document.getElementById("btn-submit");




function showThematique(){
    fetch(API_URL)
    .then(response=>response.json())
    .then(thematiques=>{
        tbody.innerHTML=""
        thematiques.forEach(thematique => {
            tbody.innerHTML+=`
            <tr>
            <td class="p-4 text-sm font-semibold text-gray-500">${thematique.name}</td>
            <td class="p-4 text-sm font-semibold text-gray-500 ">${thematique.description}</td>
            </tr>
            `
            
        });
    })
}
function showToast(message,type="success"){
    const container=document.getElementById("toast-container")
    const toast=document.createElement("div");
    toast.className="text-white px-4 py-3 rounded shadow"
    if(type=="success"){
        toast.className+="bg-green-500"
    }else{
        toast.className+="bg-red-500"
    }
    toast.textContent=message;
    container.appendChild(toast);
      setTimeout(() => {
        toast.remove();
    }, 3000);
}

form.addEventListener("submit",function(e){
    e.preventDefault()
    const data={
        name:nameF.value,
        description:descriptionF.value
    }
       spinner.classList.remove("hidden")
        btnText.textContent="enregistrer......"
        btnSubmit.disabled=true;

    fetch(API_URL,
        {
            method:"POST",
            headers:{
                "Content-Type": "application/json"
            },
            body:JSON.stringify(data)
        }
    )
    .then(response=>response.json())
    .then(()=>{
        showToast("added succesfully","success")
        form.reset();
        showThematique();
     
    })
    .catch(error=>{
        showToast(error.message,"error")
       
    })
    .finally(()=>{
         spinner.classList.add("hidden");
        btnText.textContent = "Enregistrer";
        btnSubmit.disabled = false;
    })
})



showForm.addEventListener("click",function(){
    formField.classList.remove("hidden");
})
annulerForm.addEventListener("click", function(){
    form.reset();
})
















document.addEventListener("DOMContentLoaded",showThematique())