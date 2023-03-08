// funksjon som laster inn siden på nytt
function refresh(){ 
    window.location.reload();
};

// lager en timer, som gjør at etter 300 tusen millisekunder, blir funksjonen refresh kjørt
setInterval(refresh, 300000);