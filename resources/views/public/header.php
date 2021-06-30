<nav class="navbar">
    <div class="title-navbar">
        <img src="img/menu.svg" id="btn-menu" class="cursor" alt="" height="30">
        <span class="navbar-brand mb-0 h1">Produccion SE</span>
        
    </div>
    <div class="user-data">
        <div class="user-name">{{ Auth::user()->name }}</div>
        <div class="content-user-image">
            <img src="img/animals/{{ Auth::user()->avatar }}.svg" class="user-image">
        </div>
    </div>
</nav>