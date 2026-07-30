// LOADING ----------------------------------------------------------------------------
const loading = document.getElementById('loading');
window.onload = function() {
    // loading.classList.add('hidden');
};

function loadingPush(action){ //true (no hidden) - false (hidden)
    if(action == true){
        document.getElementById('loading').classList.remove('hidden');
    } else {
        document.getElementById('loading').classList.add('hidden');
    }
}

function openMobileMenu(m_menu){
    m_menu.classList.toggle('opened');
    document.getElementById('header').classList.toggle('opened');
}

function closeMobileMenu(){
    document.getElementById('mobile_menu').classList.remove('opened');
    document.getElementById('header').classList.remove('opened');
}