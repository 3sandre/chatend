const form = document.querySelector(".signup form"),
continueBtn = form.querySelector(".button input");
//preventing form from submitiing
form.onsubmit = (e)=>{
    e.preventDefault();
}

continueBtn.onclick = ()=>{
    //ajax start
    let xhr = new XMLHttpRequest(); //create xml object
    xhr.open("POST", "php/signup.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                console.log(data);
            }
        }
    }
    //send form from ajax to php
    let formData = new FormData(form); //creating new formdata object
    xhr.send(formData);
}