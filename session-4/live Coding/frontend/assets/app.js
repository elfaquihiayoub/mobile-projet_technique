const API_URL="http://localhost:8000/backend/api/controllers/controllerThematique.php";
const tbody=document.getElementById("table-categories-body")
const form=document.getElementById("form-categorie")
const nameF=document.getElementById("cat-nom")
const descriptionF=document.getElementById("cat-desc")
const btnshowform=document.getElementById("btn-show-form")
const formSection=document.getElementById("section-form")
const btnSubmit=document.getElementById("btn-submit")
const btnTxt=document.getElementById("btn-text")
const spinner=document.getElementById("spinner")






function showThematique(){
fetch(API_URL)
.then(response=>response.json())
.then(thematiques=>{
    tbody.innerHTML=""
    thematiques.forEach(thematique => {
        tbody.innerHTML+=`
        <tr>
            <td class="p-4 text-sm font-semibold text-gray-500">${thematique.name}</td>
            <td class="p-4 text-sm font-semibold text-gray-500">${thematique.description}</td>
        
        </tr>`
        
    });
})
}


function showToast(message,type="success"){
    const container=document.getElementById("toast-container")
    const toast=document.createElement("div")
    toast.classList="p-5 m-4 rounded "


    if(type=="success"){
        toast.classList.add("bg-green-500")

    }else{
          toast.classList.add("bg-red-500")
    }
    toast.textContent=message;
    container.appendChild(toast)
    setTimeout(()=>{
        toast.remove()

    },3000)
}

form.addEventListener("submit",function(e){
    e.preventDefault();
    const data={
        name:nameF.value,
        description:descriptionF.value
    }
    spinner.classList.remove("hidden")
    btnTxt.textContent="Enregistrer en cours..."
    btnSubmit.disabled=true

    fetch(API_URL,{
        method:"POST",
        headers:{
            "Content-Type":"application/json"

        },
        body:JSON.stringify(data)   
    })
    .then(response=>response.json())
    .then(()=>{
        showToast("added success","success")
        form.reset()
        showThematique()
    }).catch(error=>{
        showToast(error.message,"error")
    }).finally(()=>{
        spinner.classList.add("hidden")
    })

})

btnshowform.addEventListener("click",function(){
    formSection.classList.remove("hidden")
    btnTxt.textContent="Enregistrer"
    btnSubmit.disabled=false

})
document.addEventListener("DOMContentLoaded",showThematique())